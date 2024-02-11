<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

trait FileTrait
{
    public function uploadFile($folder, $file, $disk = 'local')
    {
        $filename = Str::random() . '.' . $file->getClientOriginalExtension();
        $fullPath = "$folder/$filename";

        if (Storage::disk($disk)->putFile($fullPath, $file)) {
            return Storage::disk($disk)->path($fullPath); // Returns relative path
        }

        return null; // Or handle upload failure as needed
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
