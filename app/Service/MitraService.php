<?php

namespace App\Service;

use App\Models\Mitra;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class MitraService
{
    // getOne data mitra============================================================================================================
    public function getOneMitra($id){
        $da = Mitra::with('user:id,email')->where('id', $id)->first();
        if (!$da) {
            return response()->json(['message'=>'data tidak ditemukan'], 404);
        }
        return $da;
    }
    // data mitra============================================================================================================
    static public function data_mitra(){
        try {
            $datas = Mitra::query();
            if (!$datas) {
                return response()->json(['message'=> "Data Tidak Ditemukan"],404);
            }
            return $datas;
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([$th->getMessage()],500);
        }
    }
    // store mitra in admin page=================================================================================================
    static public function store_mitra($r){
        try {
            DB::beginTransaction();

            $user = new User();
            $user->name = $r->nama_mitra;
            $user->username = $r->kontak_mitra;
            $user->email = $r->email;
            $user->role = "mitra";
            $user->password = Hash::make($r->kontak_mitra);
            $user->save();
            Log::info('User baru untuk mitra kerja atas nama '.$user->name.' berhasil dibuat');

            $mitra = new Mitra();
            $mitra->user_id = $user->id;
            $mitra->nama_mitra = $r['nama_mitra'];
            $mitra->alamat_mitra = $r['alamat_mitra'];
            $mitra->kontak_mitra = $r['kontak_mitra'];
            $mitra->save();
            Log::info('Mitra kerja baru atas nama '.$mitra->nama_mitra. ' berhasil dibuat');

            DB::commit();
            return response()->json(['message' => 'Mitra baru berhasil dibuat'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::error($th);
            return response()->json([$th->getMessage()],500);
        }
    }
    // update mitra in admin page=================================================================================================
    static public function update($r){
        try {
            DB::beginTransaction();

            $da = Mitra::with('user')->where('id', $r->mid)->first();
            if (!$da) {
                return response()->json(['error' => '404 Patang Puluh Patang'], 404);
            }
            $da->update([
                'nama_mitra' => $r->nama_mitra,
                'alamat_mitra' => $r->alamat_mitra,
                'kontak_mitra' => $r->kontak_mitra,
            ]);
            Log::info('berhasil update mitra'. $da->nama_mitra);
            // Update email user yang terkait
            if ($da->user) {
                $da->user->update([
                    'name' => $r->nama_mitra,
                    'username' => $r->kontak_mitra,
                    'email' => $r->email,
                ]);
            }
            Log::info('berhasil update user mitra'. $da->nama_mitra);
            DB::commit();
            return response()->json(['message' => 'Mitra berhasil diupdate'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return response()->json([$th->getMessage()],500);
        }
    }
    // delete mitra in admin page==============================================================================================
    static public function delete($r){
        try {
            $data = Mitra::with('user:id')
                        ->where('id', $r->mid)
                        ->first();

            if (!$data) {
                return response()->json(['message'=>"Data Tidak Di temukan"],404);
            }
            if ($data->user) {
                $data->user->delete();
            }
            $data->delete();
            return response()->json(['message'=>'Data Berhasil Di Hapus']);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([$th->getMessage()],500);
        }
    }

    // get data profile==============================================================================================
    public function get_data_profile(){
        //
    }
}
