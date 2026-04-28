<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\ProdiMikro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    public function index()
    {
        $prodiList = ProdiMikro::aktif()->get();
        return view('programs', compact('prodiList'));
    }

    public function enroll(Request $request)
    {
        $request->validate(['prodi_id' => 'required|exists:prodi_mikro,id']);

        $user = Auth::user();
        $existing = Pendaftaran::where('mahasiswa_id', $user->id)
            ->where('prodi_id', $request->prodi_id)->first();

        if ($existing) {
            return back()->with('warning', 'Anda sudah terdaftar di program ini!');
        }

        Pendaftaran::create([
            'mahasiswa_id' => $user->id,
            'prodi_id' => $request->prodi_id,
            'status' => 'pending',
            'registered_at' => now(),
        ]);

        return back()->with('success', 'Pendaftaran berhasil! Menunggu verifikasi admin.');
    }
}
