<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    use HasFactory;
    protected $guarded;

    public static function generateUsername()
    {
        $tahun = date('Y');
        // ambil 2 angka terkahir dari tahun
        $getDuaAngka = substr($tahun, -2);
        // ambil data siswa terakhir
        $lastMember = self::latest()->first();
        if ($lastMember == null) {
            // jika datanya kosong maka buatkan 0001
            $noUrut = 0001;
        } else {
            $noUrut = substr($lastMember->username, 2, 4) + 1;
        }
        $noUrut = str_pad($noUrut, 4, '0', STR_PAD_LEFT);
        $username = $getDuaAngka . $noUrut;
        return $username;
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function kelas():BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'class_id', 'id');
    }
}
