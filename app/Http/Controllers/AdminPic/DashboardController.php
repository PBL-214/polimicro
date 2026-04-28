<?php

namespace App\Http\Controllers\AdminPic;

use App\Http\Controllers\Controller;
use App\Models\Makul;
use App\Models\Pendaftaran;
use App\Models\ProdiMikro;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMhs = User::mahasiswa()->count();
        $pending = Pendaftaran::pending()->count();
        $totalMatkul = Makul::count();
        $activeProdi = ProdiMikro::aktif()->count();
        $accepted = Pendaftaran::diterima()->count();
        $rejected = Pendaftaran::where('status', 'ditolak')->count();
        $prodiList = ProdiMikro::aktif()->get();
        $recentPendaftaran = Pendaftaran::with(['mahasiswa', 'prodi'])->latest()->take(5)->get();

        return view('admin-pic.dashboard', compact(
            'totalMhs', 'pending', 'totalMatkul', 'activeProdi',
            'accepted', 'rejected', 'prodiList', 'recentPendaftaran'
        ));
    }
}
