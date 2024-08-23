<?php

namespace App\Service;

use App\Models\Pembina;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserService
{
    // data user============================================================================================================
    static public function data_user(){
        try {
            $data = User::whereNot('role', 'dev')
                ->select(['id','name','username','email','role'])
                ->orderBy("created_at", 'desc')
                ->get();
            if (!$data) {
                return response()->json(['message'=> "Data Tidak Ditemukan"],404);
            }
            return $data;
        } catch (\Throwable $th) {
            //throw $th;
            Log::alert($th);
            return response()->json(['message' => 'Terjadi Kesalahan yang tidak diketahui'], 404);
        }

    }

    // get user id============================================================================================================
    static public function getById($id){
        try {
            $data = User::where('id',$id)->first(['id','name','username','email','role']);
            if (!$data) {
                return response()->json(['message'=> "Data Tidak Ditemukan"],404);
            }
            return response()->json($data);
        } catch (\Throwable $th) {
            //throw $th;
            Log::alert($th);
            return response()->json(['message' => 'Terjadi Kesalahan yang tidak diketahui'], 404);
        }

    }
    // update user============================================================================================================
    static public function update($r){
        try {
            DB::beginTransaction();
            $data = User::where('id', $r->id)->first();
            Log::info('Data user atas nama '.$data->name.' sebelum di update');
            if (!$data) {
                return response()->json(['message'=> "Data Tidak Ditemukan"],404);
            }
            $data->update([
                'name' => $r->name,
                'username' => $r->username,
                'email' => $r->email,
                'role' => $r->role,
            ]);
            if ($r->password) {
                $data->update(['password'=>$r->password]);
            }
            Log::info('Data user atas nama '.$data->name.' setelah di update');
            // jika role nya pembina
            if($data->role == 'pembina'){
                $pemb = Pembina::where('user_id', $data->id)->first();
                $pemb->update(['nama_pembina'=>$data->name]);
            }
            Log::info('Data Pembina atas nama '.$data->name.' setelah di update dari menu user');
            DB::commit();
            return response()->json(['message'=> 'Berhasil update User '.$data->name.'']);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::alert($th);
            return response()->json(['message' => 'Terjadi Kesalahan yang tidak diketahui'], 404);
        }

    }
    // delete user============================================================================================================
    static public function delete($req){
        try {
            DB::beginTransaction();
            $data = User::where('id', $req->uid)->first();

            // jika rolenya pembina
            if ($data->role == 'pembina') {
                $pem = Pembina::where('user_id', $data->id)->first();
                $pem->delete();
                Log::info('Data Pembina atas nama '.$data->name.' di hapus dari menu user');
            }
            $data->delete();
            Log::info('Data user atas nama '.$data->name.' di hapus dari menu user');
            DB::commit();
            return response()->json(['message'=>"Berhasil Hapus User"]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::alert("tejadi Kesalahan", $th);
        }

    }
    // data session login============================================================================================================
    static public function data_session(){
        return DB::table('sessions')
                ->join('users', 'sessions.user_id', '=', 'users.id')
                ->where('users.role', '<>', 'dev')
                // ->where('users.role', '<>', 'admin')
                ->select('sessions.id as session_id', 'users.name as user_name', 'sessions.last_activity', 'sessions.ip_address')
                ->get()
                ->map(function ($item) {
                    $item->last_activity = Carbon::createFromTimestamp($item->last_activity)->format('d M Y H:i:s');
                    return $item;
                });
    }
}
