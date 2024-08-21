<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role): Response
    {

        $user = Auth::user();
        if (!$user) {
            return redirect()->to(route('login'));
        }

        if ($user->role === 'dev' || $user->role === 'admin') {
            return $next($request);
        }
        // ambil session
        $sesi = DB::table('sessions')
                ->where('user_id', $user->id)
                ->get();


        if ($sesi->count() > 1 ) {
            Auth::logout();
            return back()->with('gagal_login', 'Anda Sudah Login Di Perangkat Lain');
        }

        foreach ($role as $roles) {
            if ($user->role === $roles) {
                return $next($request);
            }
        }
        return redirect()->to(route('unauthorized'));

    }
}
