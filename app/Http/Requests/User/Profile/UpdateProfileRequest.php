<?php

namespace App\Http\Requests\User\Profile;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'phone' => ['required', 'string', 'unique:users,phone,except:' . auth()->id()],
            'email' => ['required', 'email:rfc,dns', Rule::unique('users', 'email')->ignore(auth()->id(), 'id')],
            'date_of_birth' => ['required', 'string'],
        ];
    }
}
