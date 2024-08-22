<?php

namespace App\Service;

use App\Models\Pembina;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PembinaService
{
    // id pembina---------------------------------------------------------------------------------------
    static public function get_one($pid){
        try {
            $data = Pembina::with('user')->where('id', $pid)->first();
            if (!$data){
                return response()->json(['message'=>"Data Tidak Ditemukan"],404);
            }
            return response()->json($data);
        } catch (\Throwable $th) {
            //throw $th;
            Log::info($th);
            return response()->json(['message'=>"Terjadi Kesalahan"],404);
        }
    }
    // data pembina---------------------------------------------------------------------------------------
    static public function data_all(){
        try {
            $da = Pembina::query()->with('user');
            if ($da == null) {
                return response()->json(['message'=>"Data Tidak Ditemukan"],404);
            }
            return $da;
        } catch (\Throwable $th) {
            //throw $th;
            Log::info($th);
            return response()->json(['message'=>"Terjadi Kesalahan"],404);
        }

    }

    // store pembina bersamaan dengan store user---------------------------------------------------------------------------------------
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

            DB::commit();
            return response()->json(['message'=>"Berhasil Input Data"],201);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::info($th);
            return response()->json(['message'=>'Terjadi Kesalah'], 404);
        }

    }

    // update pembina---------------------------------------------------------------------------------------
    static public function update_pembina($r){
        try {
            $pem = Pembina::with('user')->where('id', $r->pid)->first();
            DB::beginTransaction();
            $pem->update([
                'nama_pembina' => $r->nama_pembina,
                'kontak' => $r->kontak,
            ]);
            DB::commit();

            return response()->json(['message'=>"Berhasil Update Data"],201);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::info($th);
            return response()->json(['message'=>'Terjadi Kesalah'], 404);
        }
    }

}
