<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class MitraService
{
    static public function data_mitra(){
        try {
            //code...
            $datas = User::query()->where('role', 'mitra')->orderBy('created_at','desc');
            if (!$datas) {
                return response()->json(['message'=> "Data Tidak Ditemukan"],404);
            }
            return $datas;
        } catch (\Throwable $th) {
            //throw $th;
            Log::info($th);
            return response()->json(['message' => 'Terjadi Kesalahan yang tidak diketahui'], 404);
        }

    }
}
