<?php

use App\Models\CategoryTranslation;
use App\Models\Language;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;


if (!function_exists('get_active_languages')) {
    function get_active_languages() {
        return Language::active()->selection()->get();
    }
}

if (!function_exists('get_default_lang')) {
    function get_active_lang() {
        return Config::get('app.locale');
    }
}

if (!function_exists('upload_image')) {
    function upload_image($image) {
        $filename = $image->hashName();
        return $filename;
    }
}

if (!function_exists('save_image')) {
    function save_image($image, $folder) {
        $image->store('/',  $folder);
    }
}

if (!function_exists('delete_image')) {
    function delete_image($image, $folder) {
        if (Storage::disk($folder)->exists(basename($image))) {
            Storage::disk($folder)->delete(basename($image));
        }
    }
}

