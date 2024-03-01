<?php

namespace App\Services\Vendor;

/**
 * Class VendorAddressService.
 */
class VendorAddressService
{
    public function store($data)
    {
        return  auth()->user()->vendor->vendorAddress()->updateOrCreate(
            ['vendor_id' => auth()->user()->vendor->id],
            [
                'contact_email' => $data['contact_email'],
                'contact_phone' => $data['contact_phone'],
                'state' => $data['state'],
                'lga' => $data['lga'],
                'address_1' => $data['address_1'],
                'address_2' => $data['address_2'] ?? null,
            ]
        );
    }
}
