<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => 'required',
            'password' => 'required',
        ];
    }

    // message
    public function messages()
    {
        return [
            'username.required' => 'Username wajib di isi',
            'password.required' => 'Password wajib di isi',
        ];
    }
}
