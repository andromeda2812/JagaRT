<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        if (!in_array($user->role, $roles)) {
            // jika bukan role yg diizinkan: kembalikan ke user dashboard
            return redirect('/user/dashboard')->withErrors(['auth' => 'Anda tidak punya izin mengakses halaman ini.']);
        }

        return $next($request);
    }
}