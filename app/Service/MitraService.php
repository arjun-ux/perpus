<?php

namespace App\Service;

use App\Models\User;

class MitraService
{
    static public function data_mitra(){
        $datas = User::query()->where('role', 'mitra');
        if (!$datas) {
            return [];
        }
        return $datas;
    }
}
