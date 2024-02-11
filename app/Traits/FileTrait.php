<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

trait FileTrait
{
    public function uploadFile($folder, $file)
    {
        if (App::environment('local')) {
            return url(Storage::url(Storage::putFile("public/$folder", $file, 'public')));
        } else {
            return $file->storeOnCloudinary($folder)->getPublicId();
        }
    }


    public function loadFile($publicId)
    {
        if (App::environment('local')) {
            return $publicId;
        } else {
            return Cloudinary::getUrl($publicId);
        }
    }

    public function deleteFile($file)
    {
        if (App::environment('local')) {
            $path = str_replace('http://127.0.0.1:8000/storage/', '', $file);
            $path = storage_path("app/public/$path");
            if (file_exists($path)) {
                return unlink($path);
            }
        } else {
            return Cloudinary::destroy($file);
        }
    }
}
