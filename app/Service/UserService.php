<?php

namespace App\Service;

use App\Models\Mitra;
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
            $data = User::whereNot('role', 'member')
                ->select(['id','name','username','email','role'])
                ->orderBy("created_at", 'desc')
                ->get();
            if (!$data) {
                return response()->json(['message'=> "Data Tidak Ditemukan"],404);
            }
            return $data;
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([$th->getMessage()],500);
        }

    }

    // store_user============================================================================================================
    public static function store_user($req){
        // echo json_encode($req->all());
        // exit();
        try {
            DB::beginTransaction();

            User::create([
                'name' => $req->name,
                'username' => $req->username,
                'email' => $req->email,
                'role' => "Admin",
                'password' => $req->password,
            ]);
            DB::commit();
            return response()->json(['message'=> 'Berhasil Menambah Admin '.$req->name.'']);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([$th->getMessage()],500);
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
            Log::error($th);
            return response()->json([$th->getMessage()],500);
        }

    }
    // update user============================================================================================================
    static public function update($r){
        try {
            DB::beginTransaction();
            $data = User::where('id', $r->id)->first();

            if (!$data) {
                return response()->json(['message'=> "Data Tidak Ditemukan"],404);
            }
            $data->update([
                'name' => $r->name,
                'username' => $r->username,
                'email' => $r->email,
            ]);
            if ($r->password) {
                $data->update(['password'=>$r->password]);
            }
            Log::info('Data user atas nama '.$data->name.' setelah di update');

            DB::commit();
            return response()->json(['message'=> 'Berhasil update User '.$data->name.'']);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            Log::error($th);
            return response()->json([$th->getMessage()],500);
        }

    }
    // delete user============================================================================================================
    static public function delete($req){
        try {
            DB::beginTransaction();
            $data = User::where('id', $req->uid)->first();

            $data->delete();

            DB::commit();
            return response()->json(['message'=>"Berhasil Hapus User"]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return response()->json([$th->getMessage()],500);
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

    // data user profile============================================================================================================

}
