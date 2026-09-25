<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Wajib diubah ke true
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:5', 'max:100'],
            'description' => ['nullable', 'string'],
            'activity_date' => ['required', 'date'],
            'status' => ['required', Rule::in(['Planned', 'Ongoing', 'Done'])],
        ];
    }
}
