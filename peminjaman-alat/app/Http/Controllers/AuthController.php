<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            LogAktivitas::create([
                'user_id'   => Auth::id(),
                'aktivitas' => 'Login ke sistem',
                'waktu'     => now(),
            ]);

            return redirect()->route('dashboard');
        }

        return back()->withErrors(['username' => 'Username atau password salah.'])->withInput();
    }

    public function logout(Request $request)
    {
        LogAktivitas::create([
            'user_id'   => Auth::id(),
            'aktivitas' => 'Logout dari sistem',
            'waktu'     => now(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
