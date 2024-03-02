<?php

namespace App\Services\Vendor;


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

        return  auth()->user()->vendor()->updateOrCreate(
            // Search criteria (replace with appropriate column(s))
            ['user_id' => auth()->user()->id],
            [
                'banner' => $imagePath ?? auth()->user()->vendor->banner,
                'name' => $data['name'],
                'description' => $data['description'],
            ]
        );
    }
}