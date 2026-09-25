<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Wajib diubah ke true agar request diizinkan
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:5', 'max:100'], // BR-01
            'description' => ['nullable', 'string'],
            'activity_date' => ['required', 'date'],                // BR-02
            'status' => ['required', Rule::in(['Planned', 'Ongoing', 'Done'])], // BR-03
        ];
    }
}
