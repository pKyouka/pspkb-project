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
        if ($this->isMethod('post')) {
            return [
                'images' => 'required|array|min:1|max:10',
                'images.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
                'is_active' => 'boolean',
            ];
        }

        return [
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'is_active' => 'boolean',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }

    public function messages(): array
    {
        return [
            'images.required' => 'Pilih minimal satu gambar banner.',
            'images.max' => 'Maksimal 10 gambar dalam sekali unggah.',
            'images.*.image' => 'Semua file harus berupa gambar.',
            'images.*.mimes' => 'Gambar banner harus berformat JPG, PNG, atau WebP.',
            'images.*.max' => 'Ukuran setiap gambar maksimal 5MB.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Gambar banner harus berformat JPG, PNG, atau WebP.',
            'image.max' => 'Ukuran gambar maksimal 5MB.',
        ];
    }
}
