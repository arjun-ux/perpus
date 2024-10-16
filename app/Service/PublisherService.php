<?php

namespace App\Service;

use App\Models\Publisher;
use Illuminate\Support\Facades\DB;

class PublisherService
{
    public static function data_publisher(){
        $data = Publisher::query();
        return $data;
    }

    // store
    public static function store_publisher($req){
        //simpan data
        try {

            DB::beginTransaction();

            Publisher::create([
                'name' => $req->name,
                'address' => $req->address,
                'phone' => $req->phone,
                'email' => $req->email,
                'website' => $req->website,
                'established_year' => $req->established_year,
            ]);

            DB::commit();
            return response()->json(['message' => 'Berhasil Menyimpan Penerbit'],200);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json(['message' => 'Terjadi Kesalahan Saat Proses Menyimpan'], 500);
        }
    }

    // update penerbit
    public static function update_publisher($req){
        echo json_encode($req->all());
        exit();
    }

    // delete penerbit
    public static function delete_publisher($req){
        try {
            DB::beginTransaction();
            $data = Publisher::find($req->pid);
            $data->delete();
            DB::commit();
            return response()->json(['message' => 'Berhasil Menghapus Penerbit'],200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json(['message' => 'Terjadi Kesalahan Saat Proses Menghapus'], 500);
        }
    }
}
