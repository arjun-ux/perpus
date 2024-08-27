<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SantriRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'niup' => 'required',
            'nim' => 'required|unique:santris,nim',
            'nama_lengkap' => 'required',
            'tmp_lahir' => 'required',
            'tgl_lahir' => 'required',
            'asrama_id' => 'required',
            'prodi_id' => 'required',

            'email' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'niup.required' => 'NIUP Wajib Di Isi',
            'nim.required' => 'NIM Wajib Di Isi',
            'nama_lengkap.required' => 'Nama Wajib Di Isi',
            'jenis_kelamin.required' => 'Pilih Jenis Kelamin',
            'asrama_id.required' => 'Pilih Asrama',
            'prodi_id.required' => 'Pilih Program Studi',
            'email.required' => 'Email Wajib Di Isi',

            'nim.unique' => 'NIM Sudah Terpakai',
        ];
    }
}
