<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart_item = $this->orderList();

        return view('frontend.pages.cart', compact('cart_item'));
    }

    public function cartForm()
    {
        $cart_item = $this->orderList();

        return view('frontend.pages.cartform', compact('cart_item'));
    }

    public function orderList()
    {
        $cart_item = session()->get('cart') ?? [];
        $new_total_price = 0;

        foreach ($cart_item as $cart) {
            $kdv_percent = $cart['kdv'] ?? 0;
            $kdv_price = ($cart['price'] * $cart['qty']) * ($kdv_percent / 100);
            $total_price = ($cart['price'] * $cart['qty']) + $kdv_price;
            $new_total_price += $total_price;
        }

        if (session()->get('coupon_code') && $new_total_price != 0) {
            $coupon = Coupon::where('name', session()->get('coupon_code'))->where('status', '1')->first();
            $coupon_price = $coupon->price ?? 0;
            $new_total_price = $new_total_price - $coupon_price;
        }

        session()->put('total_price', $new_total_price);

        if(count(session()->get('cart')) == 0) {
            session()->forget('coupon_code');
            session()->forget('total_price');
        }

        return $cart_item;
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
                'kdv' => $product->kdv,
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
        $item_total = 0;
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
            $kdv_percent_item = $product->kdv ?? 0;
            $kdv_price_item = ($product->price * $qty) * ($kdv_percent_item / 100);
            $item_total = ($product->price * $qty) + $kdv_price_item;
        }
        session(['cart' => $cart_item]);

        $this->orderList();

        if ($request->ajax()) {
            return response()->json([
                'itemTotal' => $item_total ?? 0,
                'totalPrice' => session()->get('total_price'),
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

        if(count(session()->get('cart')) == 0) {
            session()->forget('coupon_code');
        }

        return back()->withSuccess('Ürün sepetten çıkartıldı!');
    }

    public function couponcheck(Request $request)
    {

        $coupon = Coupon::where('name', $request->coupon_name)->where('status', '1')->first();

        if (empty($coupon)) {
            return back()->withError('Kupon bulunamadı!');
        }

        $coupon_code = $coupon->name ?? '';
        session()->put('coupon_code', $coupon_code);

        $coupon_price = $coupon->price ?? 0;
        session()->put('coupon_price', $coupon_price);

        $this->orderList();

        return back()->withSuccess('Kupon uygulandı!');
    }

    function generateCode()
    {
        $order_no = generateOTP(7);
        if ($this->barcodeCodeExists($order_no)) {
            return $this->generateCode();
        }
        return $order_no;
    }

    function barcodeCodeExists($order_no)
    {
        return Invoice::where('order_no', $order_no)->exists();
    }

    public function cartSave(Request $request)
    {
//        return $request->all();

        $request->validate([
            'country' => 'required|string',
            'name' => 'required|string|min:3',
            'company_name' => 'nullable',
            'address' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'zip_code' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'note' => 'nullable',
        ], [
            'country.required' => __('country alanı zorunludur'),
            'name.required' => __('name alanı zorunludur'),
            'name.min' => __('İsim alanı en az 3 karakterden oluşmalıdır.'),
            'address.required' => __('address alanı zorunludur'),
            'city.required' => __('city alanı zorunludur'),
            'district.required' => __('district alanı zorunludur'),
            'email.required' => __('email alanı zorunludur'),
            'email.email' => __('Geçerli bir e-posta adresi girilmelidir'),
            'zip_code.required' => __('zip_code alanı zorunludur'),
            'phone.required' => __('phone alanı zorunludur'),
        ]);

        $invoice = Invoice::create([
            "user_id" => auth()->user()->id ?? null,
            "order_no" => $this->generateCode(),
            "country" => $request->country ?? null,
            "name" => $request->name ?? null,
            "company_name" => $request->company_name ?? null,
            "address" => $request->address ?? null,
            "city" => $request->city ?? null,
            "district" => $request->district ?? null,
            "zip_code" => $request->zip_code ?? null,
            "email" => $request->email ?? null,
            "phone" => $request->phone ?? null,
            "note" => $request->note ?? null
        ]);

        $cart = session()->get('cart') ?? [];
        foreach ($cart as $key => $item) {
            Order::create([
                'order_no' => $invoice->order_no,
                'product_id' => $key,
                'name' => $item['name'],
                'qty' => $item['qty'],
                'kdv' => $item['kdv'],
                'price' => $item['price']
            ]);
        }
        session()->forget('cart');
        return redirect()->route('anasayfa')->withSuccess('Alışveriş başarıyla tamamlandı!');
    }
}
