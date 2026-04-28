<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\PengerjaanTugas;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $myMatkul = $user->matkulDiampu()->with('prodi')->get();

        $totalMateri = 0; $totalTugas = 0; $totalSubs = 0;
        $studentIds = collect();

        foreach ($myMatkul as $m) {
            $totalMateri += $m->materi()->count();
            $totalTugas += $m->tugas()->count();
            $m->tugas->each(fn($t) => $totalSubs += $t->submissions()->count());
            $enrolledIds = $m->prodi->pendaftaranDiterima()->pluck('mahasiswa_id');
            $studentIds = $studentIds->merge($enrolledIds);
        }
        $totalStudents = $studentIds->unique()->count();

        // Recent submissions
        $tugasIds = $myMatkul->flatMap(fn($m) => $m->tugas->pluck('id'));
        $recentSubs = PengerjaanTugas::whereIn('tugas_id', $tugasIds)
            ->with(['mahasiswa', 'tugas'])
            ->latest('waktu_kumpul')
            ->take(5)
            ->get();

        return view('dosen.dashboard', compact('user', 'myMatkul', 'totalMateri', 'totalTugas', 'totalSubs', 'totalStudents', 'recentSubs'));
    }
}
