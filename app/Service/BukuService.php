<?php

namespace App\Service;

use App\Models\Books;
use Illuminate\Support\Facades\DB;

class BukuService
{
    // get book
    public static function get_book($id){
        $data = Books::where('id', $id)->first();
        return $data;
    }
    // data
    public static function data_buku(){
        $data = Books::with('publisher')->get();
        return $data;
    }

    // stock semua buku
    public static function stock_buku(){
        return Books::sum('stock');
    }

    // store buku
    public static function save_book($req){
        $baik = $req->stock_baik;
        $rusak = $req->stock_rusak;
        $jumlah_buku = $baik + $rusak;

        try {
            DB::beginTransaction();

            Books::create([
                'title' => $req->title,
                'author' => $req->author,
                'publisher_id' => $req->publisher_id,
                'category_id' => $req->category_id,
                'isbn' => $req->isbn,
                'publish_date' => $req->publish_date,
                'stock_rusak' => $req->stock_rusak,
                'stock_baik' => $req->stock_baik,
                'stock' => $jumlah_buku,
            ]);
            DB::commit();
            return response()->json(['message' => 'Berhasil Menambah Buku'],200);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json(['message' => 'Gagal Menambah Buku'],500);
        }

    }

    // update buku
    public static function update_book($req){
        $baik = $req->stock_baik;
        $rusak = $req->stock_rusak;
        $jumlah_buku = $baik + $rusak;
        $data = Books::where('id', $req->bid)->first();

        try {
            DB::beginTransaction();
            $data->update([
                'title' => $req->title,
                'author' => $req->author,
                'publisher_id' => $req->publisher_id,
                'category_id' => $req->category_id,
                'isbn' => $req->isbn,
                'publish_date' => $req->publish_date,
                'stock_rusak' => $req->stock_rusak,
                'stock_baik' => $req->stock_baik,
                'stock' => $jumlah_buku,
            ]);
            DB::commit();
            return response()->json(['message' => 'Berhasil Update Buku'],200);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json(['message' => 'Gagal Update Buku'],500);
        }

    }

    // delete buku
    public static function delete_buku($req)
    {
        try {
            DB::beginTransaction();
            $data = Books::where('id', $req->bid)->first();
            $data->delete();
            DB::commit();
            return response()->json(['message' => 'Berhasil Menghapus Buku'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json(['message' => 'Gagal Menghapus Buku'], 500);
        }

    }
}
