<?php

namespace App\Http\Requests\Admin;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|integer|exists:categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_variable' => 'nullable',
            'variants' => 'required_if:is_variable,on|array',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'The product name is required.',
            'name.string' => 'The product name must be a valid string.',
            'name.max' => 'The product name may not be greater than 255 characters.',

            'short_description.string' => 'The short description must be a valid string.',
            'long_description.string' => 'The long description must be a valid string.',

            'base_price.required' => 'The base price is required.',
            'base_price.numeric' => 'The base price must be a numeric value.',
            'base_price.min' => 'The base price cannot be less than 0.',

            'stock.required' => 'The stock quantity is required.',
            'stock.integer' => 'The stock quantity must be an integer.',
            'stock.min' => 'The stock quantity cannot be less than 0.',

            'category_id.required' => 'The category is required.',
            'category_id.integer' => 'The category must be a valid integer.',
            'category_id.exists' => 'The selected category does not exist.',

            'featured_image.image' => 'The featured image must be a valid image file.',
            'featured_image.mimes' => 'The featured image must be a file of type: jpeg, png, jpg, gif.',
            'featured_image.max' => 'The featured image size may not exceed 2MB.',

            // 'variants.required_if' => 'Variants are required when the product is marked as variable.',
            // 'variants.array' => 'Variants must be sent as an array.',

            // 'variants.*.price.required' => 'Each variant must have a price.',
            // 'variants.*.price.numeric' => 'Each variant price must be a valid number.',
            // 'variants.*.stock.required' => 'Each variant must have a stock quantity.',
            // 'variants.*.stock.integer' => 'Each variant stock must be an integer.',
            // 'variants.*.attribute_value_ids.required' => 'Each variant must have at least one attribute value.',
            // 'variants.*.attribute_value_ids.array' => 'Attribute values must be an array.',
            // 'variants.*.attribute_value_ids.required' => 'Please Select Varaints in Combination.',
        ];
    }

    public function sanitized(): array
    {
        // dd(substr($this->sku, 4));
        $baseSku = strtoupper(substr(Str::slug($this->name), 0, 3)); // Example: "TSH"
        $sku = $baseSku . '-' . substr($this->sku, 4);
        $data = $this->validated();
        if ($this->hasFile('featured_image')) {
            $image = $this->file('featured_image');
            $imageName = time() . '-' . uniqid() . '-' . $image->getClientOriginalName();
            $image->move(public_path('uploads/products'), $imageName);
            $data['featured_image'] = asset('uploads/products/' . $imageName);
        }
        $data['sku'] = $sku;
        $data['slug'] = Str::slug($data['name']);
        $data['has_variants'] = $this->filled('is_variable');
        return $data;
    }
}
