<?php

namespace App\Http\Requests\product;

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
            'brand'          => 'required|string',
            'title'          => 'required|string',
            'description'    => 'nullable|string',
            'quantity'       => 'required|integer',
            'price'          => 'required|numeric',
            'colors'         => 'required|array',
            'colors.*'       => 'exists:colors,id',
            'sizes'          => 'required|array',
            'sizes.*'        => 'exists:sizes,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'images'         => 'nullable|array',
            'images.*'       => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
