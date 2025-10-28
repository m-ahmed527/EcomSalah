<?php

namespace App\Http\Requests\Admin\Profile;

use App\Rules\PKNumberFormat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

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

    public function sanitized()
    {
        $data = array_filter($this->validated(), function ($value) {
        return !is_null($value) && $value !== '';
    });
        $user = $this->user();
        if ($this->hasFile('avatar')) {
            $avatar = $this->file('avatar');
            $filename = 'avatar_' . time() . '.' . $avatar->getClientOriginalName();
            $filePath = asset('uploads/admin/profile/' . $filename);
            // Delete old image

            $this->unlinkImage($user?->avatar);
            // Save new one
            $avatar->move(public_path('uploads/admin/profile/'), $filename);
            $data['avatar'] = $filePath;
        }

        // ✅ Update password if provided
        if ($this->filled('password')) {
            $data['password'] = Hash::make($this->password);
        }

        return $data;
    }

    private function unlinkImage($imagePath)
    {
        if ($imagePath) {
            $filePath = public_path(parse_url($imagePath, PHP_URL_PATH));
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }
    }
}
