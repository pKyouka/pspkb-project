<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $pageId = $this->route('page')?->id;

        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $pageId,
            'content' => 'nullable|string',
            'featured_image' => 'nullable|image|max:5120',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul wajib diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'slug.unique' => 'Slug sudah digunakan.',
            'featured_image.image' => 'File harus berupa gambar.',
            'featured_image.max' => 'Ukuran gambar maksimal 5MB.',
            'status.in' => 'Status harus draft atau published.',
        ];
    }
}
