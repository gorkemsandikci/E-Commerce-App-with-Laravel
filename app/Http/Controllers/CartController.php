<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart_item = session('cart', []);
        $total_price = 0;
        foreach ($cart_item as $item) {
            $total_price += $item['price'] * $item['qty'];
        }

        if (session()->get('coupon_code')) {
            $coupon = Coupon::where('name', session()->get('coupon_code'))->where('status', '1')->first();
            $coupon_price = $coupon->price ?? 0;
            $coupon_code = $coupon->name ?? '';

            $total_price = $total_price - $coupon_price;

        } else {
            $coupon = null;
        }

        session()->put('total_price', $total_price);

        return view('frontend.pages.cart', compact('cart_item', 'total_price'));
    }

    public function add(Request $request)
    {
        $product_id = $request->productId;
        $qty = $request->qty ?? 1;
        $size = $request->size;
        $product = Product::find($product_id);

        if (!$product) {
            return back()->withError('Ürün Bulunamadı');
        }
        $cart_item = session('cart', []);

        if (array_key_exists($product_id, $cart_item)) {
            $cart_item[$product_id]['qty'] += $qty;
        } else {
            $cart_item[$product_id] = [
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->price,
                'qty' => $qty,
                'size' => $size
            ];
        }
        session(['cart' => $cart_item]);

        return back()->withSuccess('Ürün Sepete Eklendi!');
    }

    public function newQty(Request $request)
    {
        $product_id = $request->product_id;
        $qty = $request->qty ?? 1;
        $size = $request->size;
        $product = Product::find($product_id);

        if (!$product) {
            return response()->json('Ürün Bulunamadı');
        }
        $cart_item = session('cart', []);

        if (array_key_exists($product_id, $cart_item)) {
            $cart_item[$product_id]['qty'] = $qty;
            if ($qty == 0 || $qty < 0) {
                unset($cart_item[$product_id]);
            }
            $item_total = $product->price * $qty;
        }
        session(['cart' => $cart_item]);

        if ($request->ajax()) {
            return response()->json([
                'itemTotal' => $item_total ?? 0,
                'message' => 'Sepet Güncellendi'
            ]);
        }
    }

    public function remove(Request $request)
    {
        $product_id = $request->product_id;
        $cart_item = session('cart', []);

        if (array_key_exists($product_id, $cart_item)) {
            unset($cart_item[$product_id]);
        }

        session(['cart' => $cart_item]);
        return back()->withSuccess('Ürün sepetten çıkartıldı!');
    }

    public function couponcheck(Request $request)
    {
        $cart_item = session('cart', []);
        $total_price = 0;

        foreach ($cart_item as $item) {
            $total_price += $item['price'] * $item['qty'];
        }
        $coupon = Coupon::where('name', $request->coupon_name)->where('status', '1')->first();

        if (empty($coupon)) {
            return back()->withError('Kupon bulunamadı!');
        }

        $coupon_price = $coupon->price ?? 0;
        $coupon_code = $coupon->name ?? '';

        $total_price = $total_price - $coupon_price;

        session()->put('total_price', $total_price);
        session()->put('coupon_code', $coupon_code);

        return back()->withSuccess('Kupon uygulandı!');

    }
}
