<?php

namespace App\Http\Requests\User\Auth;

use App\Http\Requests\BaseRequest;

class VerifyEmailTokenRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|exists:users',
            'token' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'User with this email not found',
        ];
    }
}
