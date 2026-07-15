<?php

namespace App\Http\Controllers;

use App\Models\Sertifikat;
use Illuminate\Http\Request;

class CertificateVerificationController extends Controller
{
    public function verify($nomor_sertifikat)
    {
        $sertifikat = Sertifikat::with(['mahasiswa', 'prodi'])->where('nomor_sertifikat', $nomor_sertifikat)->first();
        
        return view('public.verify-certificate', compact('sertifikat', 'nomor_sertifikat'));
    }
}
