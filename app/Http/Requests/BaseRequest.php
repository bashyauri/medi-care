<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\ResponseTrait;

use Illuminate\Validation\Rule;

class BaseRequest extends FormRequest
{
    use ResponseTrait;
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->errorResponse($validator->errors()->first(), 422));
    }
}
