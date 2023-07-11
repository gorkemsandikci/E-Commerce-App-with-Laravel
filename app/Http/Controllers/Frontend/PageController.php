<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function urunler(Request $request, string $slug = null)
    {
        $category = $request->segment(1) ?? null;
        $size = $request->size ?? null;
        $color = $request->color ?? null;
        $start_price = $request->start_price ?? null;
        $end_price = $request->end_price ?? null;

        $order_by = $request->order_by ?? 'id';
        $sort = $request->sort ?? 'desc';

        $products = Product::where('status', '1')
            ->select([
                'id', 'name', 'slug', 'size', 'color', 'image', 'price', 'category_id'
            ])
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
            ->with('category:id,name,slug')
            ->whereHas('category', function ($query) use ($category, $slug) {
                if (!empty($slug)) {
                    $query->where('slug', $slug);
                }
                return $query;
            });

        $min_price = $products->min('price');
        $max_price = $products->max('price');

        $sizelists = Product::where('status', '1')->groupBy('size')->pluck('size')->toArray();
        $colors = Product::where('status', '1')->groupBy('color')->pluck('color')->toArray();

        $products = $products->orderBy($order_by, $sort)->paginate(21);

        return view('frontend.pages.products', compact('products', 'min_price', 'max_price', 'sizelists', 'colors'));
    }

    public function indirimdekiurunler()
    {
        return view('frontend.pages.products');
    }

    public function urundetay($slug)
    {
        $product = Product::whereSlug($slug)
            ->where('status', '1')
            ->firstOrFail();

        $products = Product::where('id', '!=', $product->id)
            ->where('category_id', $product->category_id)
            ->where('status', '1')
            ->limit(6)
            ->get();

        return view('frontend.pages.product', compact('product', 'products'));
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
}
