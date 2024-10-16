<?php

namespace App\Service;

use App\Models\Books;

class BukuService
{
    // data
    public static function data_buku(){
        $data = Books::with('publisher')->get();
        return $data;
    }

    // delete buku
    public static function delete_buku($req)
    {
//
    }
}
