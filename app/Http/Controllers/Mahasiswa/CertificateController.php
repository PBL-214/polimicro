<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $certs = $user->sertifikat()->with('prodi')->get();
        return view('mahasiswa.certificates', compact('user', 'certs'));
    }
}
