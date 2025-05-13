<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function login()
    {
        return view('auth.login');
    }

    // Proses login
    public function authenticate(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:8',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus 8 karakter.',
        ]);

        // Coba mendapatkan user berdasarkan username
        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'username' => 'Username atau password salah.',
            ])->onlyInput('username');
        }

        // Autentikasi pengguna
        Auth::login($user);
        $request->session()->regenerate();

        // Debugging (hapus setelah yakin berjalan lancar)
        // dd(Auth::user());

        // Redirect berdasarkan role
        if ($user->roles === 'admin') {
            return redirect()->route('pengiriman')->with('success', 'Login berhasil sebagai Admin!');
        } elseif ($user->roles === 'kurir') {
            return redirect()->route('rekap.data')->with('success', 'Login berhasil sebagai Kurir!');
        } else {
            // Jika role tidak dikenali, logout dan tampilkan pesan
            Auth::logout();
            return back()->withErrors([
                'username' => 'Role tidak valid. Hubungi administrator.',
            ])->onlyInput('username');
        }
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate session dan regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil.');
    }
}
