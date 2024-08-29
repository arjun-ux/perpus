<?php

namespace App\Http\Controllers;

use App\Models\Penugasan;
use Illuminate\Http\Request;

class PenugasanController extends Controller
{
    // penugasan_santri=======================================
    public function penugasan_santri(Request $r){
        $pen = Penugasan::with('mitra')->where('santri_id', $r->sid)->get();
        if (!$pen) {
            return [];
        }
        return response()->json($pen);
    }
}
