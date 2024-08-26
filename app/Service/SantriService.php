<?php

namespace App\Service;

use App\Models\Santri;
use Illuminate\Support\Facades\Log;

class SantriService
{
    // data santri============================================================================================================
    static public function data(){
        try {
            $datas = Santri::query(['id','nama_lengkap','nim','niup','stts']);
            if (!$datas) {
                return response()->json(['message'=> "Data Tidak Ditemukan"],404);
            }
            return $datas;
        } catch (\Exception $th) {
            Log::error($th);
            return response()->json([$th->getMessage()],500);
        }
    }
    // get one santri============================================================================================================
    public function get_one($r){
        try {
            $da = Santri::where('id', $r)->first();
            if (!$da) {
                return response()->json(['message'=>'Data Tidak Ditemukan'],404);
            }
            return response()->json($da);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([$th->getMessage()],500);
        }
    }
    // simpan santri============================================================================================================
    public function simpan($r){
        //
    }
}
