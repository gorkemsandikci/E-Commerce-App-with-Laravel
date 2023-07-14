<?php

use Illuminate\Support\Str;
use ImageResize;

if (!function_exists('delete_file')) {
    function delete_file($string): void
    {
        if (file_exists(public_path($string))) {
            if (!empty($string)) {
                unlink(public_path($string));
            }
        }
    }
}

if (!function_exists('image_upload')) {
    function image_upload($image, $image_name, $destination_path): string
    {
        $original_filename = $image->getClientOriginalName();
        $original_filename_arr = explode('.', $original_filename);
        $file_ext = end($original_filename_arr);
        $image_name = Str::slug($image_name) . '-' . date('d-m-Y');

        if ($file_ext == 'pdf' || $file_ext == 'svg' || $file_ext == 'webp') {
            $image->move(public_path($destination_path), $image_name . '.' . $file_ext);
        } else {
            $image = ImageResize::make($image);
            $image->encode('webp', 75)->save($destination_path . '/' . $image_name . '.webp');
            $file_ext = 'webp';
        }
        $image_url = '/' . $destination_path . '/' . $image_name . '.' . $file_ext;

        return $image_url;
    }
}
