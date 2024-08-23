<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MitraRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nama_mitra' => 'required',
            'alamat_mitra' => 'required',
            'kontak_mitra' => 'required',
            'email' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'nama_mitra.required' => "Nama Mitra Wajib Di isi",
            'alamat_mitra.required' => "Alamat Mitra Wajib Di isi",
            'kontak_mitra.required' => "Kontak Mitra Wajib Di isi",
            'email.required' => "Email Mitra Wajib Di isi",
        ];
    }
}
