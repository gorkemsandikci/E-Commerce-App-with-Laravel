<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;

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
        return view('backend.pages.slider.edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderRequest $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = $request->name;
            $destination_path = 'img/slider';
            $image_url = image_upload($image, $image_name, $destination_path, rand(99,9999));
        }

        Slider::create([
            'name' => $request->name,
            'image' => $image_name != null ? $image_url : null,
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
    public function update(SliderRequest $request, string $id)
    {
        $slider = Slider::where('id', $id)->firstOrFail();
        $image_url = $slider->image;

        if ($request->hasFile('image')) {
            delete_file($slider->image);
            $image = $request->file('image');
            $image_name = $request->name;
            $destination_path = 'img/slider';
            $image_url = image_upload($image, $image_name, $destination_path, $slider->id);
        }

        $slider->update([
            'name' => $request->name,
            'image' => $image_url ?? $slider->image,
            'link' => $request->link,
            'content' => $request->description,
            'status' => $request->status,
        ]);

        return back()->withSuccess('Slider güncellendi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $slider = Slider::where('id', $request->id)->firstOrFail();

        delete_file($slider->image);

        $slider->delete();

        return response(['error' => false, 'message' => 'Başarıyla Silindi.']);
    }

    public function statusUpdate(Request $request)
    {
        $update = $request->state;
        $update_check = $update == "false" ? '0' : '1';

        Slider::where('id', $request->id)->update(['status' => $update_check]);
        return response(['error' => false, 'status' => $update]);
    }
}
