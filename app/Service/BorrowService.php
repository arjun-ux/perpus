<?php

namespace App\Service;

use App\Models\Books;
use App\Models\Borrowing;
use App\Models\Member;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BorrowService
{
    // get borrowing by anggota
    public static function get_by_anggota($req){
        $data = User::with('member.borrow.book')->where('id', $req)->get();
        // dd($data);
        if ($data->isEmpty()) {
            return null;
        }
        return $data;
    }
    // get borrowing by tgl peminjaman
    public static function get_by_tgl_peminjaman($req){
        $data = Borrowing::with('member.user','book')->where('borrow_date', $req)->get();
        if ($data->isEmpty()) {
            return null;
        }
        return $data;
    }
    // get borrowing by tgl pengembalian
    public static function get_by_tgl_pengembalian($req){
        $data = Borrowing::with('member.user','book')->where('returned_date', $req)->get();
        if ($data->isEmpty()) {
            return null;
        }
        return $data;
    }
    // get borrowing with memeber
    public static function borrowed($id){
        $data = Borrowing::where('member_id', $id)->latest()->first();
        if ($data) {
            # code...
            return $data;
        }
        return null;
    }
    // jumlah peminjam
    public static function jml_peminjam(){
        return Borrowing::count();
    }
    // data peminjam
    public static function data_peminjam(){
        $data = Borrowing::with('member.user','book')->get();
        // $data = DB::table('members',)
        return $data;
    }
    // proses peminjaman
    public static function borrow_save($req){
        $member = Member::where('username', $req->username)->first('id'); // ambil data member
        $setting = Setting::first(); // ambil setting

        // cek seeting sudah apa belum
        if ($setting === null || $setting->borrowing_due === null) {
            return response()->json(['message' => 'Mohon Setting Aplikasi Terlebih Dahulu'], 404);
        }

        // ambil data member di dalam peminjaman terakhir
        $borrow_sebelum = Borrowing::where('member_id', $member->id)->latest()->first();


        // kembalikan error jika masih ada peminjaman
        if ($borrow_sebelum && $borrow_sebelum->status !== "Selesai") {
            return response()->json(['message' => 'Harap Kembalikan Buku yang dipinjam Sebelumnya'],404);
        }

        // mengubah string ke integer
        $due_days = (int) $setting->borrowing_due;

        // var tanggal peminjaman sekarang
        $borrow_date = Carbon::now();
        // masa akhir pengembalian
        $return_date = $borrow_date->copy()->addDays($due_days)->format('Y-m-d');

        try {
            DB::beginTransaction();

            $books = Books::find($req->book_id);

            if ($books && $books->stock > 0) {
                // Kurangi stock umum
                $books->stock--;

                // Kurangi stock berdasarkan kondisi
                if ($req->condition == 'Baik' && $books->stock_baik > 0) {
                    $books->stock_baik--;
                } elseif ($req->condition == 'Rusak' && $books->stock_rusak > 0) {
                    $books->stock_rusak--;
                } else {
                    // Jika kondisi tidak sesuai, lempar exception
                    return  response()->json(['message' => 'Kondisi Buku tidak sesuai'], 400);
                }

                $books->save(); // Simpan perubahan pada buku

                // create peminjaman
                Borrowing::create([
                    'book_id' => $req->book_id,
                    'member_id' => $member->id,
                    'condition' => $req->condition,
                    'borrow_date' => $borrow_date,
                    'due_date' => $due_days,
                    'returned_date' => $return_date,
                    'status' => 'Pinjam',
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Buku Berhasil Dipinjam'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json([$th->getMessage()],500);
        }

    }
}
