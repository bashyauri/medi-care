<?php

namespace App\Http\Requests\Vendor;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class VendorAddressRequest extends BaseRequest
{

    public function rules(): array
    {

        return [
            'contact_email' => ['required', 'max:200', 'email'],
            'contact_phone' => ['required', 'max:200'],
            'state' => ['required'],
            'lga' => ['required', 'nullable'],
            'address_1' => ['required'],
            'address_2' => ['string'],
        ];
    }
}