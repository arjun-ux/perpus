<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penugasan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function magang(){
        return $this->belongsTo(Magang::class, 'magang_id', 'id');
    }

    public function santri(){
        return $this->belongsTo(Santri::class, 'santri_id', 'id');
    }

    public function mitra(){
        return $this->belongsTo(Mitra::class, 'mitra_id', 'id');
    }
}
