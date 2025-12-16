<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); 
    }

    public function login(Request $request)
    {
        // Validasi
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Ambil user berdasarkan username
        $user = User::where('username', $request->username)->first();

        // Cek jika user ditemukan
        if ($user) {
            // Cek status akun
            if ($user->status === 'nonaktif') {
                return back()->with([
                    'status_inactive' => true,
                    'message' => 'Akun Anda telah dinonaktifkan. Silakan hubungi admin.'
                ]);
            }
        }

        // Auth attempt
        if (Auth::attempt(
            ['username' => $credentials['username'], 'password' => $credentials['password']], 
            $request->filled('remember')
        )) {
            $request->session()->regenerate();

            // Arahkan berdasarkan role
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            }
            return redirect()->intended('/user/dashboard');
        }

        // Login gagal
        return back()
            ->withErrors(['username' => 'Username atau password salah'])
            ->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'Anda telah logout.');
    }
}