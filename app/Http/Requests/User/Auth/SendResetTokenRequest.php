<?php

namespace App\Http\Requests\User\Auth;

use App\Http\Requests\BaseRequest;


class SendResetTokenRequest extends BaseRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|exists:users',
         ];
    }
    public function messages()
    {
        return [
            'email.exists'=> 'Email not found',
        ];
    }
}
