<?php

namespace App\Http\Requests\Vendor;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;

class UserVendorRequest extends BaseRequest
{


    public function rules(): array
    {
        return [
            'banner' =>  ['required', 'file', 'mimes:jpeg,png,jpg', File::types(['jpg', 'png', 'jpeg'])
                ->max(5024)],
            'name' => ['required', 'max:200'],
            'description' => ['required', 'string'],
        ];
    }
}
