<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                'regex:/^[0-9]{12}@mhs\.dinus\.ac\.id$/'
            ],
            'nim' => [
                'required',
                'string',
                'unique:users',
                'regex:/^A22\.2023\.[0-9]{5}$/',
                function ($attribute, $value, $fail) {
                    if (!User::validateNimEmail($value, $this->email)) {
                        $fail('NIM tidak sesuai dengan format email mahasiswa.');
                    }
                }
            ],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'email.regex' => 'Email harus menggunakan format email mahasiswa UDINUS.',
            'nim.regex' => 'NIM harus menggunakan format yang benar (A22.2023.XXXXX).',
        ];
    }
}
