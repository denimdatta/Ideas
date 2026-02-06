<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return  array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'min:5',
                'max:25',
                'unique:users,username',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'confirmed',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::default(),
            ],
            'first_name' => [
                'required',
                'string',
                'max:250',
            ],
            'last_name' => [
                'required',
                'string',
                'max:250',
            ],
        ];
    }
}
