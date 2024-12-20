<?php

namespace App\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AuthService
{
    // dologin============================================================================================================
    static public function do_login($request){
        if (Auth::attempt($request)) {
            session()->regenerate();
            return redirect()->route('dashboard')->with('success_login', 'Selamat datang kembali');
        }else {
            Log::alert('Login Gagal dengan Username ' .$request['username']);
            return redirect()->back()->with('gagal_login', 'Username Atau Password Salah!');
        }
    }
    // dologout============================================================================================================
    static public function do_logout(Request $request){
        if (!Auth::user()->role === "dev" || !Auth::user()->role === "admin" || !Auth::user()->role === "pembina" || !Auth::user()->role === "mitra") {
            DB::table('sessions')->where('user_id', Auth::user()->id)->delete();
            $request->session()->flush();
        }
        Log::info('User atas nama '. Auth::user()->name.' Telah Logout');

        Auth::logout(); // logout
        $request->session()->flush();
        $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
