<?php

namespace App\Http\Requests\User\Auth;

use App\Http\Requests\BaseRequest;

class ResetTokenRequest extends BaseRequest
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
            'password' => 'required',
            'password_confirm' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'token.exists' => 'User token not found',
        ];
    }
}
