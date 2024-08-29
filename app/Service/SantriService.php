<?php

namespace App\Service;

use App\Imports\SantriImport;
use App\Jobs\ImportSantriExcelJob;
use App\Models\Santri;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class SantriService
{
    // data santri============================================================================================================
    static public function data(){
        try {
            $datas = Santri::query()->orderBy('id', 'desc');
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
    public function store($r){
        try {
            $use = User::create([
                'name'=> $r->nama_lengkap,
                'username'=> $r->nim,
                'email'=> $r->email,
                'password' => Hash::make($r->niup),
                'role' => 'santri',
            ]);
            Santri::create([
                "niup" => $r->niup,
                "nim" => $r->nim,
                "nama_lengkap" => $r->nama_lengkap,
                "jenis_kelamin" => $r->jenis_kelamin,
                "tmp_lahir" => $r->tmp_lahir,
                "tgl_lahir" => $r->tgl_lahir,
                "skill" => $r->skill,
                "no_ortu" => $r->no_ortu,
                "id_telegram" => $r->id_telegram,
                "asrama_id" => $r->asrama_id,
                "prodi_id" => $r->prodi_id,
                "user_id" => $use->id,
                "stts" => 'Aktif',
            ]);
            if ($r->action == 'save') {
                return redirect()->route('index_admin')->with('success', 'Berhasil Menyimpan Data Santri');
            }
            return redirect()->back()->with('success', 'Berhasil Simpan Data Santri');
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th);
            return response()->json([$th->getMessage()],500);
        }
    }

    // update santri============================================================================================================



    // delete santri============================================================================================================
    public function delete($r){
        try {
            $da = Santri::with('user')->where('id', $r)->first();
            if ($da->user) {
                $da->user->delete();
            }
            $da->delete();
            return response()->json(['message'=>'Data Berhasil Dihapus'],200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([$th->getMessage()],500);
        }
    }

    // import santri============================================================================================================
    public function import($r){
        if ($r->hasFile('file_santri')) {
            $fs = Excel::toArray(new SantriImport, request()->file('file_santri'), null, \Maatwebsite\Excel\Excel::XLSX);
            $data = $fs[0];
            $santri = [];
            foreach ($data as $value) {
                // dd(Carbon::parse($value['tanggal_lahir']));

                $santri[] = [
                    'niup' => $value['niup'],
                    'nim' => $value['nim'],
                    'nama_lengkap' => $value['nama'],
                    'tmp_lahir' => $value['tempat_lahir'],
                    'tgl_lahir' => Carbon::parse($value['tanggal_lahir'])->toDateString(),
                    'jenis_kelamin' => $value['jenis_kelamin'],
                    'skill' => $value['skill'],
                    'no_ortu' => $value['no_ortu'],
                    'id_telegram' => $value['id_telegram'],
                    'stts' => 'Aktif',
                ];
            }
            // dd($santri);
            try {
                DB::beginTransaction();

                DB::table('santris')->insert($santri);

                DB::commit();
                return response()->json(['message' => 'Data berhasil diimpor!']);
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error($th);
                return response()->json([$th->getMessage()],500);
            }
        }
    }

    // generate user
    public function generateUser($r){
        try {
            $ids = $r->ids;
            $ds = Santri::whereIn('id', $ids)->get(); // datasantri berdasarkan id di atas

            DB::beginTransaction();
            $sudahPunyaUser = [];
            foreach ($ds as $s) {
                if ($s->user_id !== null) {
                    $sudahPunyaUser[] = $s->nama_lengkap .' Sudah Memiliki User';
                    Log::info($s->nama_lengkap .' Sudah Memiliki User');
                }else {
                    $us = User::create([
                        'name' => $s->nama_lengkap,
                        'username' => $s->nim,
                        'password' => $s->nim,
                        'role' => 'santri',
                    ]);
                    $s->update(['user_id'=>$us->id]);
                }
            }
            // dd($sudahPunyaUser);
            DB::commit();
            return response()->json(['message'=>'Berhasil Create User Form Santri',]);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return response()->json([$th->getMessage()],500);
        }
    }

    // generateUserOne=============================================================================
    public function generateUserOne($r){
        try {
            $sa = Santri::where('id', $r->id)->first();
            DB::beginTransaction();
            $user = User::create([
                "name" => $sa->nama_lengkap,
                "username" => $sa->nim,
                "password" => $sa->nim,
                "role" => "santri",
            ]);
            $sa->update(['user_id'=>$user->id]);
            DB::commit();
            return response()->json(['message'=>'Berhasil Generate User Dari Santri Ini']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return response()->json([$th->getMessage()],500);
        }
    }

    // export santri=============================================================================
    public function export($r){
        //
    }
    // get data santri=============================================================================
    public function get_data_profile(){
        $data = Santri::where('user_id', Auth::user()->id)->first();
        return response()->json($data);
    }
}
