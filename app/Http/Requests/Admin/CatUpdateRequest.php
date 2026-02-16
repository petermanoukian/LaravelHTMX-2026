<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class CatUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        Log::info('CatUpdateRequest raw input', $this->all());
    }

    public function rules(): array
    {
        $idParam = $this->route('cat') ?? $this->route('id');

        // normalize if it's a model
        if ($idParam instanceof \App\Models\Cat) {
            $id = $idParam->id;
        } else {
            $id = (int) $idParam;
        }

        return [
            'name'   => [
                'required',
                'string',
                Rule::unique('cats', 'name')->ignore($id),
            ],
            'des'    => ['nullable','string','max:255'],
            'dess'   => ['nullable','string'],
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


    protected function failedValidation(Validator $validator)
    {
        Log::error('CatUpdateRequest validation failed', $validator->errors()->toArray());

        throw (new ValidationException($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
