<?php

namespace App\Http\Controllers;

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

//        dd($cart_item);
        return view('frontend.pages.cart', compact('cart_item', 'total_price'));
    }

    public function add(Request $request)
    {
        $product_id = $request->productId;
        $qty = $request->qty;
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
}
