<?php

namespace App\Http\Requests\product;

use Illuminate\Foundation\Http\FormRequest;

class update extends FormRequest
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
            'brand'          => 'nullable|string',
            'title'          => 'nullable|string',
            'description'    => 'nullable|string',
            'quantity'       => 'nullable|integer',
            'price'          => 'nullable|numeric',
            'colors'         => 'nullable|array',
            'colors.*'       => 'exists:colors,id',
            'sizes'          => 'nullable|array',
            'sizes.*'        => 'exists:sizes,id',
            'subcategory_id' => 'nullable|exists:sub_categories,id',
        ];
    }
}
