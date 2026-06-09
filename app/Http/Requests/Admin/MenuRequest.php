<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama menu wajib diisi.',
            'location.required' => 'Lokasi menu wajib diisi.',
        ];
    }
}
