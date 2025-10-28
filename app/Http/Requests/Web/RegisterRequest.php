<?php

namespace App\Http\Requests\Web;

use App\Rules\PKNumberFormat;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['nullable', 'string', 'max:50'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', new PKNumberFormat()],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Please enter your first name.',
            'first_name.string' => 'First name must be a valid text.',
            'first_name.max' => 'First name cannot exceed 50 characters.',

            'last_name.string' => 'Last name must be a valid text.',
            'last_name.max' => 'Last name cannot exceed 50 characters.',

            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',

            'phone.required' => 'Phone number is required.',

            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a valid text value.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }
    public function sanitized(): array
    {
        $validated = $this->validated();

        return [
            'first_name' => ucfirst(trim(strip_tags($validated['first_name']))),
            'last_name' => ucfirst(trim(strip_tags($validated['last_name']))) ?? null,
            'email' => strtolower(trim($validated['email'])),
            'phone' => preg_replace('/\D/', '', $validated['phone']), // Remove non-digit characters
            'password' => $validated['password'],
        ];
    }
}
