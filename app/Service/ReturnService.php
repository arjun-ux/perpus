<?php

namespace App\Service;

use App\Models\Books;
use App\Models\Borrowing;
use App\Models\Returning;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class ReturnService
{
    // jumlah pengembalian
    public static function jml_pengembalian(){
        return count(Returning::all());
    }

    // ambil data buku yang dipinjam berdasarkan
    // username / id member
    public static function get_borrowing($req){
        // get member
        $member = MemberService::get_member($req);

        // get peminjaman
        $borrow = BorrowService::borrowed($member->id);
        // dd($borrow);
        if ($borrow == null) {
            return response()->json(['message' => 'Tidak Ada Pinjaman'],404);
        }
        if ($borrow && $borrow->status == "Selesai") {
            return response()->json(['message' => 'Tidak Ada Pinjaman'],404);
        }
        // ambil buku
        $book = BukuService::get_book($borrow->book_id);
        // return $book;

        if ($borrow && $member) {

            $currentDate = date('Y-m-d'); // Mengambil tanggal saat ini
            $overdueItems = [];
            $totalFine = 0;
            $denda_set = Setting::first();

            // Menghitung keterlambatan hanya jika $borrow adalah objek tunggal
            if ($borrow->returned_date < $currentDate) {
                // Menghitung jumlah hari keterlambatan
                $overdueDays = (strtotime($currentDate) - strtotime($borrow->returned_date)) / (60 * 60 * 24);

                // Menghitung denda
                $fine = $overdueDays * $denda_set->denda;
                $totalFine += $fine;

                // Menyimpan item yang terlambat beserta denda
                $overdueItems = [
                    'item' => $borrow,
                    'overdue_days' => $overdueDays,
                    'fine' => $fine,
                ];
            }

            $data = [
                'member' => $member,
                'borrow' => $borrow,
                'overdue' => $overdueItems,
                'total_fine' => $totalFine,
                'book' => $book,
                'setting' => $denda_set,
            ];
            return $data;
        }
        return response()->json(['message' => 'Data tidak ditemukan'],404);
    }

    // simpan pengembalian buku
    public static function save_return($req) {
        // Fetch the borrowing record
        $borrow = Borrowing::find($req->borrow_id);

        if (!$borrow) {
            return response()->json(['message' => 'Borrow record not found'], 404);
        }

        // Fetch the associated book
        $book = Books::find($borrow->book_id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        try {
            DB::beginTransaction();

            // Update the book's stock based on its condition
            $book->stock++;

            if ($req->condition === "Baik") {
                $book->stock_baik++;
            } elseif ($req->condition === "Rusak") {
                $book->stock_rusak++;
            } elseif ($req->condition === "Hilang") {
                $book->stock--;
            } else {
                return response()->json(['message' => 'Invalid condition provided'], 400);
            }

            $book->save();

            // Update the borrowing record to mark it as returned
            $borrow->update([
                'returned_date' => now(),
                'status' => 'Selesai',
            ]);

            // Create a new returning record
            Returning::create([
                'borrow_id' => $req->borrow_id,
                'return_date' => now(),
                'condition' => $req->condition,
                'denda' => $req->total_denda,
            ]);

            DB::commit();
            return response()->json(['message' => 'Berhasil Mengembalikan Buku'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

}
