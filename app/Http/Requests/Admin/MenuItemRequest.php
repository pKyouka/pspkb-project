<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:500',
            'parent_id' => 'nullable|exists:menu_items,id',
            'order_number' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul item menu wajib diisi.',
            'parent_id.exists' => 'Parent menu tidak valid.',
        ];
    }
}
