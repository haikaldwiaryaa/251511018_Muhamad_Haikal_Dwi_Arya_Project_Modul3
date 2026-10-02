<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (!$this->has('status') || empty($this->status)) {
            $this->merge(['status' => 'draft']);
        }
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'poster' => ['nullable', 'image', 'max:2048'],
            'code' => ['required', 'string', 'max:30', 'unique:activities,code'],
            'title' => ['required', 'string', 'min:5', 'max:100'],
            'description' => ['nullable', 'string'],
            'activity_date' => ['required', 'date'],
            'status' => ['nullable', 'in:draft,published,completed'],
        ];
    }
}
