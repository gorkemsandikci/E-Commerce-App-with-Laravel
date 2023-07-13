<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use ImageResize;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::all();
        return view('backend.pages.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderRequest $request)
    {
        if($request->hasFile('image')) {
            $original_filename = $request->file('image')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = 'img/slider';
            $image_name = Str::slug($request->name) . '-' . date('d-m-Y');
            $image = $request->file('image');

            if($file_ext == 'pdf' || $file_ext == 'svg' || $file_ext == 'webp') {
                $image->move(public_path($destination_path), $image_name . '.' . $file_ext);
            } else {
                $image = ImageResize::make($image);
                $image->encode('webp', 75)->save($destination_path . '/' . $image_name.'.webp');
            }
        }

        Slider::create([
            'name' => $request->name,
            'image' => $image_name ?? null,
            'link' => $request->link,
            'content' => $request->description,
            'status' => $request->status,
        ]);

        return back()->withSuccess('Slider oluşturuldu!');

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
        $slider = Slider::where('id', $id)->first();
        return view('backend.pages.slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
