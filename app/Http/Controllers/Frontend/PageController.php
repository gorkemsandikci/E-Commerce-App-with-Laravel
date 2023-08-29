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

        $sizes = !empty($request->size) ? explode(',', $request->size) : null;

        $colors = !empty($request->color) ? explode(',', $request->color) : null;

        $start_price = $request->min ?? null;
        $end_price = $request->max ?? null;

        $order_by = $request->order_by ?? 'id';
        $sort = $request->sort ?? 'desc';

        $products = Product::where('status', '1')
            ->select([
                'id', 'name', 'slug', 'size', 'color', 'image', 'price', 'category_id', 'qty'
            ])
            ->where(function ($query) use ($sizes, $colors, $start_price, $end_price) {
                if (!empty($sizes)) {
                    $query->whereIn('size', $sizes);
                }
                if (!empty($colors)) {
                    $query->whereIn('color', $colors);
                }
                if (!empty($start_price) && !empty($end_price)) {
                    $query->where('price', '>=', $start_price);
                    $query->where('price', '<=', $end_price);
                }
                return $query;
            })
            ->with('category:id,name,slug')
            ->whereHas('category', function ($query) use ($category, $slug) {
                if (!empty($slug)) {
                    $query->where('slug', $slug);
                }
                return $query;
            })->orderBy($order_by, $sort)->paginate(21);;

        if ($request->ajax()) {
            $data = view('frontend.ajax.productList', compact('products'))->render();
            return response(['data' => $data, 'paginate' => (string) $products->withQueryString()->links('pagination::custom')]);
        }

        $sizelists = Product::where('status', '1')->groupBy('size')->pluck('size')->toArray();

        $colors = Product::where('status', '1')->groupBy('color')->pluck('color')->toArray();

        $maxprice = Product::max('price');

        return view('frontend.pages.products', compact('products', 'maxprice', 'sizelists', 'colors'));
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
