<?php

namespace App\Http\Requests\Web;

use App\Rules\PKNumberFormat;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'first_name' => ['nullable', 'string', 'max:50'],
            'last_name' => ['nullable', 'string', 'max:50'],
            'phone' => ['nullable', new PKNumberFormat()],
            'address' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:50'],
            'province' => ['nullable', 'string', 'max:50'],
            'city' => ['nullable', 'string', 'max:50'],
            'zip' => ['nullable', 'string', 'max:10'],
        ];
    }

    public function messages(): array
    {
        return [

            'first_name.string' => 'First name must be a valid text.',
            'first_name.max' => 'First name cannot exceed 50 characters.',

            'last_name.string' => 'Last name must be a valid text.',
            'last_name.max' => 'Last name cannot exceed 50 characters.',

            'phone.required' => 'Phone number is required.',

            'address.string' => 'Address must be a valid text.',
            'address.max' => 'Address cannot exceed 100 characters.',
            'country.string' => 'Country must be a valid text.',
            'country.max' => 'Country cannot exceed 50 characters.',
            'province.string' => 'Province must be a valid text.',
            'province.max' => 'Province cannot exceed 50 characters.',
            'city.string' => 'City must be a valid text.',
            'city.max' => 'City cannot exceed 50 characters.',
            'zip.string' => 'ZIP code must be a valid text.',
            'zip.max' => 'ZIP code cannot exceed 10 characters.',
        ];
    }
    public function sanitized(): array
    {
        return [
            'first_name' => ucfirst(trim(strip_tags($this?->first_name ?? auth()->user()?->first_name))),
            'last_name' => ucfirst(trim(strip_tags($this?->last_name ?? auth()->user()?->last_name))),
            'phone' => preg_replace('/\D/', '', $this?->phone ?? auth()->user()?->phone), // Remove non-digit characters
            'address' => $this?->address ?? auth()->user()?->address,
            'country' => $this?->country ?? auth()->user()?->country,
            'province' => $this?->province ?? auth()->user()?->province,
            'city' => $this?->city ?? auth()->user()?->city,
            'zip' => $this?->zip ?? auth()->user()?->zip,
        ];
    }
}
