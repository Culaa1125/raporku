<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string',  // hapus rule 'email', ganti ke 'string'
            'password' => 'required|string',
        ], [
            'email.required'    => 'Email / NIS wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $input = $request->email;

        // Cek apakah input berformat email atau NIS
        if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
            // Login pakai email biasa
            $credentials = ['email' => $input, 'password' => $request->password];
        } else {
            // Login pakai NIS — cari email siswa terlebih dahulu
            $siswa = \App\Models\Siswa::where('nis', $input)->first();

            if (!$siswa) {
                return back()->withErrors(['email' => 'Email atau NIS tidak ditemukan.'])->withInput();
            }

            $credentials = ['email' => $siswa->user->email, 'password' => $request->password];
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectByRole(Auth::user()->role);
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }

    private function redirectByRole(string $role)
    {
        return match ($role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'guru'   => redirect()->route('guru.dashboard'),
            'siswa'  => redirect()->route('siswa.dashboard'),
            default  => redirect()->route('login'),
        };
    }
}