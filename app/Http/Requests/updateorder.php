<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateorder extends FormRequest
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
            'color_id' => 'nullable|integer|exists:colors,id',
            'product_id' => 'nullable|integer|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
            'size_id' => 'nullable|integer|exists:sizes,id',
            'address'=>'nullable|string',
        ];
        
    }
}
