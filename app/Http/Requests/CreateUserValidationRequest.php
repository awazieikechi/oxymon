<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUserValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:App\Models\User,email'],
            'phone_number' => ['required', 'numeric', 'unique:App\Models\User,phone_number'],
            'password' => ['required', 'string'],
            'address' => ['nullable', 'string'],

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = response()->json([
            'message' => 'Invalid data sent',
            'details' => $errors->messages(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
