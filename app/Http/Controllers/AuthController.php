<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->getDashboardRoute());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route(Auth::user()->getDashboardRoute()));
        }

        return back()->withErrors(['email' => 'Email atau password salah!'])->onlyInput('email');
    }

    public function showRegister()
    {
        $programs = \App\Models\ProdiMikro::where('status', 'aktif')->get();
        return view('auth.register', compact('programs'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:6|confirmed',
            'prodi_id' => 'required|exists:prodi_mikro,id',
        ]);

        $lastNim = User::mahasiswa()->max('nim') ?? '2024000';
        $newNim = str_pad((int)$lastNim + 1, 7, '0', STR_PAD_LEFT);

        $user = new User([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'nim' => $newNim,
            'status' => 'pending',
        ]);
        $user->role = 'mahasiswa'; // Explicitly set — not mass-assignable
        $user->save();

        \App\Models\Pendaftaran::create([
            'mahasiswa_id' => $user->id,
            'prodi_id' => $request->prodi_id,
            'status' => 'pending',
            'registered_at' => now()
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Akun dan Pendaftaran Anda menunggu verifikasi admin.');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            return back()->with('success', 'Link reset password telah dikirim ke email Anda.');
        }

        return back()->withErrors(['email' => 'Email tidak ditemukan!']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
