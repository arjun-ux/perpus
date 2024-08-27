<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;
    protected $guarded = [];

    // relasi ke user
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    //relasi ke asrama
    public function asrama(){
        return $this->belongsTo(Asrama::class, 'asrama_id','id');
    }

    // relasi ke prodi
    public function prodi(){
        return $this->belongsTo(Prodi::class, 'prodi_id', 'id');
    }

    // relasi ke magang
    public function magang(){
        return $this->belongsTo(Magang::class, 'magang_id', 'id');
    }
}
