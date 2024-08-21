<?php

namespace App\Service;

use App\Models\Santri;

class SantriService
{
    static public function data_santri(){
        $datas = Santri::query(['id','nama_lengkap','nim','niup','stts']);
        if (!$datas) {
            return [];
        }
        return $datas;
    }
}
