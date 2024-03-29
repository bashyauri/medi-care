<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rules\File;

class VendorServiceRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    public function rules(): array
    {
        return [
            'service_type_id' => ['required'],
            'license_number' => ['required', Rule::unique('vendor_services', 'license_number')],
            'license_issueing_body' => ['required'],
            'document' => ['required', 'file', 'mimes:pdf', File::types(['pdf'])
                ->max(5024)],
            'expiry_date' => ['required']

        ];
    }
}
