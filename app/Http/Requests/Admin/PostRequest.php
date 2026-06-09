<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class PostRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $plainContent = trim(strip_tags((string) $this->input('content', '')));
        $excerpt = trim((string) $this->input('excerpt', ''));
        $title = trim((string) $this->input('title', ''));
        $tagsInput = (string) $this->input('tags_input', '');
        $tags = array_values(array_filter(array_map(
            fn ($tag) => trim($tag),
            explode(',', $tagsInput)
        )));

        $this->merge([
            'slug' => $this->filled('slug') ? Str::slug($this->input('slug')) : Str::slug($title),
            'excerpt' => $excerpt !== '' ? $excerpt : Str::limit($plainContent, 160, ''),
            'meta_title' => $this->filled('meta_title') ? $this->input('meta_title') : Str::limit($title, 60, ''),
            'meta_description' => $this->filled('meta_description')
                ? $this->input('meta_description')
                : Str::limit($excerpt !== '' ? $excerpt : $plainContent, 160, ''),
            'tags' => $tags,
        ]);
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $postId = $this->route('post')?->id;

        return [
            'category_id' => 'nullable|exists:categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug,' . $postId,
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:5120',
            'thumbnail_media_path' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:100',
            'status' => 'required|in:draft,published',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul wajib diisi.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'slug.unique' => 'Slug sudah digunakan.',
            'category_id.exists' => 'Kategori tidak valid.',
            'thumbnail.image' => 'File harus berupa gambar.',
            'thumbnail.max' => 'Ukuran gambar maksimal 5MB.',
            'status.in' => 'Status harus draft atau published.',
        ];
    }
}
