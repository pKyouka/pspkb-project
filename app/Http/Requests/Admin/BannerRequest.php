<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:5120',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|url|max:500',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul banner wajib diisi.',
            'title.max' => 'Judul banner maksimal 255 karakter.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimal 5MB.',
            'button_url.url' => 'URL button harus valid.',
        ];
    }
}
