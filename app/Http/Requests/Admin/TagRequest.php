<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tagId = $this->route('tag')?->id;

        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tags,slug,' . $tagId,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama tag wajib diisi.',
            'name.max' => 'Nama tag maksimal 255 karakter.',
            'slug.unique' => 'Slug sudah digunakan.',
        ];
    }
}
