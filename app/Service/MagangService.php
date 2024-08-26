<?php

namespace App\Service;

use App\Models\Magang;
use Illuminate\Support\Facades\Log;

class MagangService
{
    // get one data============================================================================================================
    public function getOne($id){
        $da = Magang::where('id', $id)->first();
        return response()->json($da);
    }
    // data============================================================================================================
    public function getAll(){
        try {
            $dts = Magang::query()->orderBy('id', 'desc');
            return $dts;
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([$th->getMessage()],500);
        }
    }
    // store============================================================================================================
    public function store($req){
        try {
            Magang::query()->create([
                'tema_magang' => $req->tema_magang,
                'tgl_mulai' => $req->tgl_mulai,
                'tgl_selesai' => $req->tgl_selesai,
                'stts_magang' => 'Ongoing',
            ]);
            return response()->json(['message'=>'Berhasil Input Magang']);
        } catch (\Exception $th) {
            Log::error($th);
            return response()->json([$th->getMessage()],500);
        }
    }
    // upate ============================================================================================================
    public function update($req){
        try {
            Magang::query()->where('id', $req->mid)->update([
                'tema_magang' => $req->tema_magang,
                'tgl_mulai' => $req->tgl_mulai,
                'tgl_selesai' => $req->tgl_selesai,
                'stts_magang' => $req->stts_magang,
            ]);
            return response()->json(['message'=>"Berhasil Update Magang"]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([$th->getMessage()],500);
        }
    }
    // delete ============================================================================================================
    public function delete($id){
        try {
            Magang::query()->where('id',$id)->delete();
            return response()->json(['message'=>'Magang Berhasil Dihapus']);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([$th->getMessage()],500);
        }
    }
}
