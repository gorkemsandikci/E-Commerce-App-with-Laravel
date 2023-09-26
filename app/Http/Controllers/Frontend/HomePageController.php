<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Product;
use App\Models\Slider;

class HomePageController extends Controller
{
    public function index()
    {
        $slider = Slider::where('status', '1')->first();
        $title = 'Anasayfa';
        $about = About::where('id', '1')->first();
        $last_products = Product::where('status', '1')
            ->select([
                'id', 'name', 'slug', 'size', 'color', 'price', 'category_id', 'image'
            ])
            ->with('category')
            ->limit(10)
            ->orderBy('id', 'desc')
            ->get();

        return view('frontend.pages.index', compact('slider', 'title', 'about', 'last_products'));
    }
}
