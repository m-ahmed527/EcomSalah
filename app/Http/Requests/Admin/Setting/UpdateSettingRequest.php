<?php

namespace App\Http\Requests\Admin\Setting;

use App\Models\Setting;
use App\Rules\PKNumberFormat;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;

class UpdateSettingRequest extends FormRequest
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
            // 🟢 General Settings
            'site_name' => 'nullable|string|max:100',
            'site_email' => 'nullable|email|max:100',
            'site_phone' => ['nullable', 'max:20', 'string', new PKNumberFormat()],

            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', // 2MB limit
            'favicon' => 'nullable|image|mimes:ico,png,jpg,svg|max:1024',  // 1MB limit

            // 🟢 Social Links
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',

            // 🟢 Email Settings
            'mail_host' => 'nullable|string|max:100',
            'mail_port' => 'nullable|numeric',
            'mail_username' => 'nullable|string|max:100',
            'mail_password' => 'nullable|string|max:100',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            // General
            'site_name.max' => 'Site name must not exceed 100 characters.',
            'site_email.email' => 'Please enter a valid email address.',
            'site_email.max' => 'Site email must not exceed 100 characters.',
            'site_phone.max' => 'Phone number must not exceed 20 characters.',

            // Logo & Favicon
            'logo.image' => 'The site logo must be an image file.',
            'logo.mimes' => 'Logo must be of type: jpeg, png, jpg, or svg.',
            'logo.max' => 'Logo image may not be larger than 2MB.',
            'favicon.image' => 'The favicon must be an image file.',
            'favicon.mimes' => 'Favicon must be of type: ico, png, jpg, or svg.',
            'favicon.max' => 'Favicon image may not be larger than 1MB.',

            // Social Links
            'facebook.url' => 'Please enter a valid Facebook URL.',
            'twitter.url' => 'Please enter a valid Twitter URL.',
            'instagram.url' => 'Please enter a valid Instagram URL.',
            'linkedin.url' => 'Please enter a valid LinkedIn URL.',

            // Email Settings
            'mail_host.max' => 'SMTP host must not exceed 100 characters.',
            'mail_port.numeric' => 'SMTP port must be a valid number.',
            'mail_username.max' => 'SMTP username must not exceed 100 characters.',
            'mail_password.max' => 'SMTP password must not exceed 100 characters.',
        ];
    }

    public function sanitized()
    {
        $data = $this->validated();
        $uploadPath = public_path('uploads/settings');

        // Ensure directory exists
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0777, true);
        }

        /** ✅ Handle logo upload with old file deletion */
        if ($this->hasFile('logo')) {
            // delete old logo
            $oldLogo = Setting::get('logo');
            if ($oldLogo) {
                $oldPath = public_path(str_replace(asset(''), '', $oldLogo));
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            // upload new logo
            $logo = $this->file('logo');
            $logoName = 'logo_' . time() . '_' . $logo->getClientOriginalName();
            $logo->move($uploadPath, $logoName);
            $data['logo'] = asset('uploads/settings/' . $logoName);
        }

        /** ✅ Handle favicon upload with old file deletion */
        if ($this->hasFile('favicon')) {
            // delete old favicon
            $oldFavicon = Setting::get('favicon');
            if ($oldFavicon) {
                $oldPath = public_path(str_replace(asset(''), '', $oldFavicon));
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            // upload new favicon
            $favicon = $this->file('favicon');
            $faviconName = 'favicon_' . time() . '_' . $favicon->getClientOriginalName();
            $favicon->move($uploadPath, $faviconName);
            $data['favicon'] = asset('uploads/settings/' . $faviconName);
        }

        return $data;
    }
}
