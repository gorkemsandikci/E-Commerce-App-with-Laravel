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

        SiteSetting::firstOrCreate([
            'name' => $key,
        ],[
            'name' => $key,
            'data' => $request->data,
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

        $key = $request->name;

        if ($request->hasFile('data')) {
            delete_file($setting->data);
            $image = $request->file('data');
            $image_name = $key;
            $destination_path = 'img/setting';
            $image_url = image_upload($image, $image_name, $destination_path);
        }

        $setting->update([
            'name' => $key,
            'data' => $image_url ?? $request->data,
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
