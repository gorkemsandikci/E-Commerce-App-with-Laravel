<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category:id,cat_ust,name')->orderBy('id', 'desc')->paginate(20);
        return view('backend.pages.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('backend.pages.product.edit', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = $request->name;
            $destination_path = 'img/products';
            $image_url = image_upload($image, $image_name, $destination_path, rand(99,9999));
        }

        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'content' => $request->description,
            'qty' => $request->qty,
            'color' => $request->color,
            'size' => $request->size,
            'price' => $request->price,
            'short_text' => $request->short_text,
            'image' => $image_url ?? null,
            'status' => $request->status,
        ]);

        return back()->withSuccess('Ürün oluşturuldu!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::where('id', $id)->first();

        $categories = Category::get();
        return view('backend.pages.product.edit', compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $product = Product::where('id', $id)->firstOrFail();
        $image_url = $product->image;

        if ($request->hasFile('image')) {
            delete_file($product->image);
            $image = $request->file('image');
            $image_name = $request->name;
            $destination_path = 'img/products';
            $image_url = image_upload($image, $image_name, $destination_path, $id);
        }

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'content' => $request->description,
            'qty' => $request->qty,
            'color' => $request->color,
            'size' => $request->size,
            'price' => $request->price,
            'short_text' => $request->short_text,
            'image' => $image_url,
            'status' => $request->status,
        ]);

        return back()->withSuccess('Kategori güncellendi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $product = Product::where('id', $request->id)->firstOrFail();

        delete_file($product->image);

        $product->delete();

        return response(['error' => false, 'message' => 'Başarıyla Silindi.']);
    }

    public function statusUpdate(Request $request)
    {
        $update = $request->state;
        $update_check = $update == "false" ? '0' : '1';

        Product::where('id', $request->id)->update(['status' => $update_check]);
        return response(['error' => false, 'status' => $update]);
    }
}
