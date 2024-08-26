<?php

namespace App\Service;

use App\Models\Asrama;
use Illuminate\Support\Facades\Log;


class SettingService
{
    // get one asrama=====================================================================================
    public function getOneAsrama($id){
        $as = Asrama::where('id', $id)->first();
        return response()->json($as);
    }
    // data asrama=====================================================================================
    public function data_asrama(){
        return Asrama::query(['id','nama_asrama'])->orderBy('id','desc');
    }
    // simpan asrama
    public function simpan($req){
        // try simpan data to db
        try {
            Asrama::create(['nama_asrama' => $req->nama_asrama]);
            Log::info('simpan berhasil');
            return response()->json(['message' => 'Berhasil Simpan asrama Baru']);
        } catch (\Exception $th) {
            Log::error($th);
            return response()->json([$th->getMessage()],500);
        }
    }
    // update asarama=====================================================================================
    public function update($req){
        try {
            $da = Asrama::where('id', $req->id)->first();
            $da->update(['nama_asrama' => $req->nama_asrama]);
            return response()->json(['message'=>'Berhasil Update Data Asrama'],201);
        } catch (\Exception $th) {
            Log::error($th);
            return response()->json([$th->getMessage()],500);
        }
    }

    // delete asrama=====================================================================================
    public function delete($r){
        try {
            $res = Asrama::where('id', $r)->first();
            $res->delete();
            return response()->json(['message'=>'Berhasil Hapus Asrama']);
        } catch (\Exception $th) {
            Log::error($th);
            return response()->json([$th->getMessage()],500);
        }
    }
}
