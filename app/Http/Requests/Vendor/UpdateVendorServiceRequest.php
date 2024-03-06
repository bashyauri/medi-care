<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rules\File;


class UpdateVendorServiceRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'service_type_id' => ['required'],
            'license_number' => ['required', Rule::unique('vendor_services', 'license_number')->ignore(auth()->id(), 'id')],
            'license_issueing_body' => ['required'],
            'document' => ['required', 'file', 'mimes:pdf', File::types(['pdf'])
                ->max(5024)],
            'expiry_date' => ['required'],
        ];
    }
}
