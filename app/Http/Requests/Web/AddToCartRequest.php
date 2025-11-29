<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
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
            'product_id' => 'sometimes|exists:products,id',
            'variant_id' => 'sometimes|exists:product_variants,id',
            'product-quantity' => 'required|integer|min:1'
        ];
    }

    public function messages()
    {
        return [
            'variant_id.required' => 'Variant is required.',
            'variant_id.exists' => 'Invalid variant.',
            'product-quantity.required' => 'Quantity is required.',
            'product-quantity.integer' => 'Quantity must be an integer.',
            'product-quantity.min' => 'Quantity must be at least 1.',
        ];
    }
}
