<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class store extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'     => 'required|string',
            'phone'    => 'required|string|min:13|max:13|unique:users,phone',
            'email'    => 'required|email|unique:users,email',
            'is_male'  => 'required|boolean',
            'birth'    => 'required|date',
            'image'    => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
