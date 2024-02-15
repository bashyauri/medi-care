<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserVendorRequest extends BaseRequest
{


    public function rules(): array
    {
        return [
            'shop_image' => ['required', 'image', 'max:3000'],
            'shop_name' => ['required', 'max:200'],
            'shop_email' => ['required', 'email'],
            'shop_phone' => ['required', 'max:200'],
            'shop_address' => ['required'],
            'about' => ['required']
        ];
    }
}