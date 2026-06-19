<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'website_name' => 'nullable|string|max:255',
            'website_description' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|max:2048',
            'remove_logo' => 'nullable|boolean',
            'favicon' => 'nullable|mimes:ico,png,jpg,jpeg,webp,svg|max:1024',
            'remove_favicon' => 'nullable|boolean',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'contact_address' => 'nullable|string|max:500',
            'contact_heading' => 'nullable|string|max:255',
            'contact_description' => 'nullable|string|max:1000',
            'contact_hours' => 'nullable|string|max:255',
            'social_facebook' => 'nullable|url|max:500',
            'social_instagram' => 'nullable|string|max:255',
            'social_linkedin' => 'nullable|url|max:500',
            'social_youtube' => 'nullable|url|max:500',
            'social_tiktok' => 'nullable|string|max:255',
            'seo_meta_title' => 'nullable|string|max:255',
            'seo_meta_description' => 'nullable|string|max:500',
            'seo_keywords' => 'nullable|string|max:500',
        ];
    }
}
