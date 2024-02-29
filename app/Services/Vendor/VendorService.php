<?php

namespace App\Services\Vendor;

use App\Models\Vendor;
use App\Traits\ImageUploadTrait;

/**
 * Class VendorService.
 */
class VendorService
{
    use ImageUploadTrait;
    public function requestVendor($request, $data)
    {
        $imagePath = $this->uploadImage($request, 'banner', 'vendor/uploads');

        return  auth()->user()->vendor()->create(
            [
                'banner' => $imagePath,
                'name' => $data['name'],
                'description' => $data['description'],

            ]
        );
    }
}
