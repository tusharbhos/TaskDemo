<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name'  => ['required', 'string', 'max:50'],
            'email'      => ['required', 'email', 'max:100', 'unique:users,email'],
            'password'   => [
                'required', 'string', 'min:8', 'confirmed',
                'regex:/[A-Z]/',      // at least one uppercase
                'regex:/[a-z]/',      // at least one lowercase
                'regex:/[0-9]/',      // at least one digit
                'regex:/[@$!%*#?&]/', // at least one special char
            ],
            'role' => ['required', 'in:employee,dealer'],
        ];

        // Dealer-only fields
        if ($this->input('role') === 'dealer') {
            $rules['company_name'] = ['required', 'string', 'max:100'];
            $rules['phone']        = ['nullable', 'string', 'max:20'];
            $rules['city']         = ['required', 'string', 'max:100'];
            $rules['state']        = ['required', 'string', 'max:100'];
            $rules['zip']          = ['required', 'string', 'regex:/^\d{5}(-\d{4})?$/'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'password.regex'    => 'Password must include uppercase, lowercase, number, and a special character (@$!%*#?&).',
            'zip.regex'         => 'ZIP code must be in format 12345 or 12345-6789.',
            'email.unique'      => 'This email address is already registered.',
        ];
    }
}
