<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\PengerjaanTugas;
use App\Models\Sertifikat;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $enrolled = $user->getEnrolledMatkul();
        $submissions = $user->submissions()->with('tugas.makul')->get();
        $certs = $user->sertifikat;

        // Upcoming deadlines (tugas belum dikumpul)
        $submittedTugasIds = $submissions->pluck('tugas_id')->toArray();
        $upcoming = collect();
        foreach ($enrolled as $matkul) {
            $tasks = $matkul->tugas()->whereNotIn('id', $submittedTugasIds)->get();
            foreach ($tasks as $t) {
                $t->matkul_nama = $matkul->nama_makul;
                $upcoming->push($t);
            }
        }

        // Average grade
        $graded = $submissions->whereNotNull('nilai');
        $avgGrade = $graded->count() > 0 ? round($graded->avg('nilai')) : 0;

        return view('mahasiswa.dashboard', compact('user', 'enrolled', 'submissions', 'certs', 'upcoming', 'avgGrade'));
    }
}
