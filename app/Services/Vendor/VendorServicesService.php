<?php

namespace App\Services\Vendor;

use App\Models\VendorService;
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
        return $this->vendor()->vendorServices()->create([
            'service_type_id' => $data['service_type_id'],
            'license_number' => $data['license_number'],
            'license_issueing_body' => $data['license_issueing_body'],
            'document' => $imagePath,
            'expiry_date' => $data['expiry_date'],
        ]);
    }
    public function update(array $data, $id, $request, $vendorService)
    {
        $imagePath = $this->uploadImage($request, 'document', 'vendor/documents');
        return  $this->vendor()->vendorServices()->where('id', $id)->update([
            'service_type_id' => $data['service_type_id'],
            'license_number' => $data['license_number'],
            'license_issueing_body' => $data['license_issueing_body'],
            'document' => $imagePath ?? $vendorService->document,
            'expiry_date' => $data['expiry_date'],
        ]);
    }

    public function destroy($id)
    {
        $this->vendor()->vendorServices()->where('id', $id)->delete();
    }

    private function vendor()
    {
        return auth()->user()->vendor;
    }
}
