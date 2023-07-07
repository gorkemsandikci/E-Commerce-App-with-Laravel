<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function urunler()
    {
        return view('frontend.pages.products');
    }
    public function indirimdekiurunler()
    {
        return view('frontend.pages.products');
    }
    public function urundetay()
    {
        return view('frontend.pages.product');
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
