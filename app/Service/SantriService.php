<?php

namespace App\Service;

use App\Models\Santri;
use Illuminate\Support\Facades\Log;

class SantriService
{
    // data santri============================================================================================================
    static public function data_santri(){
        try {

            $datas = Santri::query(['id','nama_lengkap','nim','niup','stts']);
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
