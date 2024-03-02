<?php

namespace App\Services\Vendor;

use App\Traits\ImageUploadTrait;

/**
 * Class VendorServicesService.
 */
class VendorServicesService
{
    use ImageUploadTrait;
    public function store($request, $data)
    {
        $imagePath = $this->uploadImage($request, 'document', 'vendor/documents');
        return $this->user()->vendor->vendorServices()->create([
            'service_type_id' => $data['service_type_id'],
            'license_number' => $data['license_number'],
            'license_issueing_body' => $data['license_issueing_body'],
            'document' => $imagePath,
            'expiry_date' => $data['expiry_date'],
        ]);
    }
    private function user()
    {
        return auth()->user();
    }
}