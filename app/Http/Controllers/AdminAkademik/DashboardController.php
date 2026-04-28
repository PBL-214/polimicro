<?php

namespace App\Http\Controllers\AdminAkademik;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\ProdiMikro;
use App\Models\Sertifikat;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDosen = User::dosen()->count();
        $totalProdi = ProdiMikro::count();
        $totalCerts = Sertifikat::count();
        $totalMhs = User::mahasiswa()->count();
        $dosenList = User::dosen()->get();
        $prodiList = ProdiMikro::all();

        return view('admin-akademik.dashboard', compact(
            'totalDosen', 'totalProdi', 'totalCerts', 'totalMhs', 'dosenList', 'prodiList'
        ));
    }
}
