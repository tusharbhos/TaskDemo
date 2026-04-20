<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealerProfileRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:100'],
            'phone'        => ['nullable', 'string', 'max:20'],
            'city'         => ['required', 'string', 'max:100'],
            'state'        => ['required', 'string', 'max:100'],
            'zip'          => ['required', 'string', 'regex:/^\d{5}(-\d{4})?$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'zip.regex' => 'ZIP code must be in format 12345 or 12345-6789.',
        ];
    }
}
