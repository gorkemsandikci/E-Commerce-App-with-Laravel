<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function urunler(Request $request)
    {
        $size = $request->size;

        $size = $request->size ?? null;
        $color = $request->color ?? null;
        $start_price = $request->start_price ?? null;
        $end_price = $request->end_price ?? null;

        $products = Product::where('status', '1')
            ->where(function ($query) use ($size, $color, $start_price, $end_price) {
                if (!empty($size)) {
                    return $query->where('size', $size);
                }
                if (!empty($color)) {
                    return $query->where('color', $color);
                }
                if (!empty($start_price) && !empty($end_price)) {
                    return $query->whereBetween('price', [$start_price, $end_price]);
                }
                return $query;
            })
            ->paginate(2);

        return view('frontend.pages.products', compact('products'));
    }

    public function indirimdekiurunler()
    {
        return view('frontend.pages.products');
    }

    public function urundetay($slug)
    {
        $product = Product::whereSlug($slug)->first();
        return view('frontend.pages.product', compact('product'));
    }

    public function hakkimizda()
    {
        $about = About::where('id', 1)->first();
        return view('frontend.pages.about', compact('about'));
    }

    public function iletisim()
    {
        return view('frontend.pages.contact');
    }

    public function sepet()
    {
        return view('frontend.pages.cart');
    }
}
