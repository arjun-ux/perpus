<?php

namespace App\Service;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    public static function data_category(){
        return Category::query()->orderBy('created_at', 'desc');
    }

    // store kategori
    public static function store_category($req){
        try {
            DB::beginTransaction();
            Category::create([
                'name' => $req->name,
            ]);
            DB::commit();
            return response()->json(['message' => "Berhasil Menyimpan Data"], 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json(['message' => 'Terjadi Kesalahan Menyimpan Data'],500);
        }
    }

    // update categry
    public static function update_category($req)
    {
        try {
            DB::beginTransaction();
            $data = Category::where('id', $req->cid)->first();
            $data->update([
                'name' => $req->name,
            ]);
            DB::commit();
            return response()->json(['message' => "Berhasil Update Data"], 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json(['message' => 'Terjadi Kesalahan Update Data'],500);
        }
    }

    // delete kategori
    public static function delete_category($req){
        try {
            DB::beginTransaction();
            $data = Category::where('id', $req->cid)->first();
            $data->delete();
            DB::commit();
            return response()->json(['message' => "Berhasil Menghapus Data"], 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json(['message' => 'Terjadi Kesalahan Menghapus Data'],500);
        }
    }
}
