<?php

namespace App\Services\Vendor;

use App\Models\User;

use App\Notifications\Admin\VendorServiceDeletedNotification;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\DB;


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
        $admins = User::where('role', 'admin')->get();
        $vendorService = $this->vendor()->vendorServices()->where('id', $id)->first();
        DB::transaction(function () use ($id, $admins, $vendorService) {

            foreach ($admins as $admin) {
                $admin->notify(new VendorServiceDeletedNotification($this->vendor()->name));
            }
            $documentPath = $vendorService->document;

            $this->vendor()->vendorServices()->where('id', $id)->delete();
            $this->deleteImage($documentPath);
        });
    }

    private function vendor()
    {
        return auth()->user()->vendor;
    }
}
