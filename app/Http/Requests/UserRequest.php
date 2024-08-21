<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'role' => 'required|string|in:admin,santri,mitra',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa string.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',

            'username.required' => 'Username wajib diisi.',
            'username.string' => 'Username harus berupa string.',
            'username.max' => 'Username tidak boleh lebih dari 255 karakter.',

            'role.required' => 'Role wajib diisi.',
            'role.string' => 'Role harus berupa string.',
            'role.in' => 'Role harus salah satu dari berikut: admin, santri, mitra.',
        ];
    }
}
