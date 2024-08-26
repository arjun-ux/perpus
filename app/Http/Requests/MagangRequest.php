<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MagangRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'tema_magang' => 'required',
            'tgl_mulai' => 'required',
            'tgl_selesai' => 'required',
            'stts_magang' => 'sometimes|required'
        ];
    }
    public function messages()
    {
        return [
            'tema_magang.required' => 'Tema Magang Wajib Di Isi',
            'tgl_mulai.required' => 'Tanggal Mulai  Wajib Di Isi',
            'tgl_selesai.required' => 'Tanggal Selesai Wajib Di Isi',
            'stts_magang.required' => 'Status Wajib Di Isi',
        ];
    }
}
