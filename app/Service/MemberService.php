<?php

namespace App\Service;

use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MemberService
{

    public static function data(){
        try {
            $data = Member::with('user','kelas')->get('members.*');
            return $data;
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['message' => "Data Tidak Ditemukan"]);
        }

    }

    // store member
    public static function store_member($request){
        try {
            DB::beginTransaction();

            $um = User::create([
                'name' => $request->name,
                'username' => $request->nis,
                'role' => 'Member',
                'password' => $request->nis,
            ]);
            Member::create([
                'user_id' => $um->id,
                'class_id' => $request->kelas,
                'username' => $um->username,
                'status' => 1,
            ]);

            DB::commit();
            return response()->json(['message'=> 'Berhasil Menambah Anggota']);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([$th->getMessage()],500);
        }
    }

    // update member
    public static function update_member($req) {
        try {
            // Mencari anggota berdasarkan username
            $find = Member::with('user', 'kelas')->where('id', $req->uid)->firstOrFail();

            DB::beginTransaction();

            // Memperbarui data pengguna
            $user = $find->user; // Ambil user yang ada
            $user->update([
                'username' => $req->username,
                'name' => $req->name,
            ]);

            // Memperbarui data anggota
            $find->update([
                'username' => $req->username,
                'class_id' => $req->kelas,
                'status' => $req->status,
            ]);

            DB::commit();
            return response()->json(['message'=> 'Berhasil Memperbarui Anggota']);

        } catch (\Throwable $th) {
            DB::rollBack();
            // Log kesalahan untuk debug

            Log::error($th->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat memperbarui anggota.'], 500);
        }
    }

    // hapus anggota
    public static function delete_member($username) {
        try {
            DB::beginTransaction();

            $user = User::where('username', $username)->first();
            if (!$user) {
                return response()->json(['error' => 'User tidak ditemukan.'], 404);
            }
            $user->delete();

            $member = Member::where('username', $username)->first();
            if (!$member) {
                return response()->json(['error' => 'Member tidak ditemukan.'], 404);
            }
            $member->delete();

            DB::commit();
            return response()->json(['message'=> 'Berhasil Menghapus Anggota']);
        } catch (\Throwable $th) {
            // Menangkap kesalahan lain
            DB::rollBack();
            Log::error($th->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus anggota.'], 500);
        }
    }



}
