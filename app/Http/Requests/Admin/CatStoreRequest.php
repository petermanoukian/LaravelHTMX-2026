<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CatStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'   => 'required|string|unique:cats,name',
            'des'    => 'nullable|string|max:255',
            'dess'   => 'nullable|string',
            'img' => [
                'nullable',
                'file',
                'max:69990',
                'mimetypes:image/jpeg,image/jpg,image/png,image/gif,image/webp,image/tiff',
            ],

            'filer' => [
                'nullable',
                'file',
                'max:69990',
                'mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,
                           application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,
                           text/plain,image/jpeg,image/png',
            ],
        ];
    }
}

