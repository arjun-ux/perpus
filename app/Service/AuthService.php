<?php

namespace App\Service;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthService
{
    // login
    static public function do_login($request){
        if (Auth::attempt($request)) {
            if (Auth::user()->role == 'admin' || Auth::user()->role == 'pembina' || Auth::user()->role == 'dev') {
                // dd($request);
                session()->regenerate();
                Session::put('user_id', Auth::user()->id); // menyimpna session di table session
                return redirect()->route('dashboard')->with('success_login', 'Selamat datang kembali');

            }elseif (Auth::user()->role == 'santri') {

                session()->regenerate();
                Session::put('user_id', Auth::user()->id); // menyimpna session di table session
                return redirect()->route('santri.dashboard')->with('success_login', 'Selamat datang kembali');

            }elseif (Auth::user()->role == 'mitra') {

                session()->regenerate();
                Session::put('user_id', Auth::user()->id); // menyimpna session di table session
                return redirect()->route('mitra.dashboard')->with('success_login', 'Selamat datang kembali');
            }
        }else {
            return redirect()->back()->with('gagal_login', 'Username Atau Password Salah!');
        }
    }
    // logout
    static public function do_logout(Request $request){
        // DB::table('sessions')->where('user_id', Auth::user()->id)->delete();
        Auth::logout(); // logout
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
