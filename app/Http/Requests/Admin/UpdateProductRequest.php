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
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Product Name',
            'short_description' => 'Short Description',
            'long_description' => 'Long Description',
            'base_price' => 'Base Price',
            'stock' => 'Stock',
            'featured_image' => 'Featured Image',
        ];
    }

    public function sanitized(): array
    {
        $baseSku = strtoupper(substr(Str::slug($this->name), 0, 3)); // Example: "TSH"
        $sku = $baseSku . '-' . str_pad(Product::count() + 1, 4, '0', STR_PAD_LEFT);
        $data = $this->validated();
        if ($this->hasFile('featured_image')) {
            $image = $this->file('featured_image');
            $imageName = time() . '-' . uniqid() . '-' . $image->getClientOriginalName();
            $image->move(public_path('uploads/products'), $imageName);
            $data['featured_image'] = asset('uploads/products/' . $imageName);
        }
        $data['sku'] = $sku;
        $data['slug'] = Str::slug($data['name']);
        $data['has_variants'] = $this->filled('variants');
        return $data;
    }
}
