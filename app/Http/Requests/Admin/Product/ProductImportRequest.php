<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'file' => 'required|file|mimes:csv,txt|max:10240', // max 10MB, adjust as needed
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'Please select a CSV file to upload.',
            'file.mimes' => 'Only CSV or TXT files are allowed.',
            'file.max' => 'File size must be less than 10MB.',
        ];
    }
}
