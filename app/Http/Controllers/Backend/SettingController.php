<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::get();
        return view('backend.pages.setting.index', compact('settings'));
    }

    public function create()
    {
        return view('backend.pages.setting.edit');
    }

    public function store(Request $request)
    {
        $key = $request->name;

        $image_url = null;
        if ($request->hasFile('data')) {
            $image = $request->file('image');
            $image_name = $request->name;
            $destination_path = 'img/setting';
            $image_url = image_upload($image, $image_name, $destination_path, rand(999,99999));
        }

        SiteSetting::firstOrCreate([
            'name' => $key,
        ],[
            'name' => $key,
            'data' => $image_url ?? $request->data,
            'set_type' => $request->set_type
        ]);

        return back()->withSuccess('Başarıyla oluşturuldu.');

    }

    public function edit(string $id)
    {
        $setting = SiteSetting::where('id', $id)->first();
        return view('backend.pages.setting.edit', compact('setting'));
    }

    public function update(Request $request, string $id)
    {
        $setting = SiteSetting::where('id', $id)->first();

        if ($request->hasFile('data')) {
            delete_file($setting->data);
            $image = $request->file('data');
            $image_name = $request->name;
            $destination_path = 'img/setting';
            $image_url = image_upload($image, $image_name, $destination_path, rand(999,99999));
        }

        if($setting->set_type == 'image' || $setting->set_type == 'file') {
            $data_item = $image_url ?? $setting->data;
        } else {
            $data_item = $request->data ?? $setting->data;
        }

        $setting->update([
            'name' => $request->name,
            'data' => $data_item,
            'set_type' => $request->set_type
        ]);

        return back()->withSuccess('Başarıyla güncellendi.');

    }

    public function destroy(Request $request)
    {
        $setting = SiteSetting::where('id', $request->id)->firstOrFail();

        $setting->delete();

        return response(['error' => false, 'message' => 'Başarıyla Silindi.']);
    }
}
