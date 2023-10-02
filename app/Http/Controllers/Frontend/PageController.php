<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Category;
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

        $main_category = null;
        $sub_category = null;

        if (!empty($category) && empty($slug)) {
            $main_category = Category::where('slug', $category)->first();
        } else if (!empty($category) && !empty($slug)) {
            $sub_category = Category::where('slug', $slug)->first();
            if (empty($sub_category->cat_ust)) {
                $main_category = Category::where('slug', $slug)->first();
                $sub_category = null;
            } else {
                $main_category = Category::where('id', $sub_category->cat_ust)->first();
            }
        }

        $breadcrumb = [
            'sayfalar' => [
            ],
            'active' => 'Ürünler'
        ];

        if (!empty($main_category) && empty($sub_category)) {
            $breadcrumb['active'] = $main_category->name;
        }

        if (!empty($sub_category)) {
            $breadcrumb['sayfalar'][] = [
                'link' => route('urunler', $main_category->slug),
                'name' => $main_category->name
            ];
            $breadcrumb['active'] = $sub_category->name;
        }

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
            })->orderBy($order_by, $sort)->paginate(21);

        if ($request->ajax()) {
            $data = view('frontend.ajax.productList', compact('products'))->render();
            return response(['data' => $data, 'paginate' => (string)$products->withQueryString()->links('pagination::custom')]);
        }

        $sizelists = Product::where('status', '1')->groupBy('size')->pluck('size')->toArray();

        $colors = Product::where('status', '1')->groupBy('color')->pluck('color')->toArray();

        $maxprice = Product::max('price');

        return view('frontend.pages.products', compact('breadcrumb', 'products', 'maxprice', 'sizelists', 'colors'));
    }

    public function indirimdekiurunler()
    {
        $breadcrumb = [
            'sayfalar' => [
            ],
            'active' => 'İndirimdeki Ürünler'
        ];

        return view('frontend.pages.products', compact('breadcrumb'));
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
            ->orderBy('id', 'desc')
            ->get();

        $category = Category::where('id', $product->category_id)->first();

        $breadcrumb = [
            'sayfalar' => [
            ],
            'active' => $product->name
        ];


        if (!empty($category)) {
            $breadcrumb['sayfalar'][] = [
                'link' => route('urunler', $category->slug),
                'name' => $category->name
            ];
        }


        return view('frontend.pages.product', compact('breadcrumb', 'product', 'products'));
    }

    public function hakkimizda()
    {
        $about = About::where('id', 1)->first();

        $breadcrumb = [
            'sayfalar' => [
            ],
            'active' => 'Hakkımızda'
        ];

        return view('frontend.pages.about', compact('breadcrumb','about'));
    }

    public function iletisim()
    {
        $breadcrumb = [
            'sayfalar' => [
            ],
            'active' => 'İletişim'
        ];

        return view('frontend.pages.contact', compact('breadcrumb'));
    }
}
