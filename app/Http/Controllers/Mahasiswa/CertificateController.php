<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $certs = $user->sertifikat()->with('prodi')->latest()->paginate(5);
        return view('mahasiswa.certificates', compact('user', 'certs'));
    }

    public function print($id)
    {
        $user = Auth::user();
        $sertifikat = $user->sertifikat()->with('prodi')->findOrFail($id);
        
        return view('mahasiswa.certificate-print', compact('sertifikat', 'user'));
    }
}
