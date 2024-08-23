<?php

namespace App\Service;

use App\Models\Pembina;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PembinaService
{
    // id pembina============================================================================================================
    static public function get_one($pid){
        try {
            $data = Pembina::with('user')->where('id', $pid)->first();
            if (!$data){
                return response()->json(['message'=>"Data Tidak Ditemukan"],404);
            }
            return response()->json($data);
        } catch (\Throwable $th) {
            //throw $th;
            Log::alert($th);
            return response()->json(['message'=>"Terjadi Kesalahan"],404);
        }
    }
    // data pembina============================================================================================================
    static public function data_all(){
        try {
            $da = Pembina::query()->with('user');
            if ($da == null) {
                return response()->json(['message'=>"Data Tidak Ditemukan"],404);
            }
            return $da;
        } catch (\Throwable $th) {
            //throw $th;
            Log::alert($th);
            return response()->json(['message'=>"Terjadi Kesalahan"],404);
        }

    }

    // store pembina bersamaan dengan store user============================================================================================================
    static public function store_pembina_with_user($r){
        try {
            DB::beginTransaction();

            $user = User::create([
                "name" => $r->nama_pembina,
                "username" => $r->username,
                "email" => $r->email,
                "password" => Hash::make($r->username),
                "role" => "pembina",
            ]);

            DB::table('pembinas')->insert([
                "user_id" => $user->id,
                "nama_pembina" => $r->nama_pembina,
                "kontak" => $r->kontak,
            ]);

            Log::info('Pembina Baru atas Nama '.$user->name);
            DB::commit();
            return response()->json(['message'=>"Berhasil Input Data"],201);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::alert($th);
            return response()->json(['message'=>'Terjadi Kesalah'], 404);
        }

    }

    // update pembina============================================================================================================
    static public function update_pembina($r){
        try {
            DB::beginTransaction();

            $pem = Pembina::where('id', $r->pid)->first();

            Log::info('Pembina Sebelum Di Update  '.$pem->nama_pembina);
            $pem->update([
                'nama_pembina' => $r->nama_pembina,
                'kontak' => $r->kontak,
            ]);

            // update nama user juga
            $user = User::where('id', $pem->user_id)->first();
            $user->update([
                'name' => $r->nama_pembina,
            ]);

            Log::info('User dan Pembina Telah Di Update dengan nama '.$user->name. ' Dari Menu Pembina');
            DB::commit();
            return response()->json(['message'=>"Berhasil Update Data"],201);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::alert($th);
            return response()->json(['message'=>'Terjadi Kesalah'], 404);
        }
    }
    // delete pembina============================================================================================================
    static public function delete_pembina($r){
        try {
            DB::beginTransaction();

            $pem = Pembina::where('id', $r->pid)->first();
            $user = User::where('id', $pem->user_id)->first();
            if ($user) {
                $user->delete();
            }
            $pem->delete();

            Log::info('Data Pembina dan User '.$pem->nama_pembina.' Telah Dihapus Dari Menu Pembina');
            DB::commit();
            return response()->json(['message' => 'Pembina Berhasil Di Hapus']);
        } catch (\Throwable $th) {
            Log::alert($th);
            DB::rollBack();
            return response()->json(['message' => 'Terjadi Kesalahan...'], 404);
        }
    }

}
