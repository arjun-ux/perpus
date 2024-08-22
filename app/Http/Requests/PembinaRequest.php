<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembinaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nama_pembina' => 'required',
            'kontak' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
        ];

    }
    public function messages()
    {
        return [
            "nama_pembina.required" => "Nama Wajib Di Isi",
            "kontak.required" => "Kontak Wajib Di Isi",
            "username.required" => "Username Wajib Di Isi",
            "email.required" => "Email Wajib Di Isi",

            "email.unique" => "Email Telah Terpakai",
            "username.unique" => "Username Telah Terpakai"
        ];
    }
}
