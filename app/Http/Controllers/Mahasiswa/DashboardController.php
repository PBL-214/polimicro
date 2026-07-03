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

        // Upcoming deadlines
        $submittedTugasIds = $submissions->pluck('tugas_id')->toArray();
        $upcoming = collect();
        $totalTasksCount = 0;
        
        foreach ($enrolled as $matkul) {
            $allTasks = $matkul->tugas;
            $totalTasksCount += $allTasks->count();
            
            // Per course progress
            $courseTasksCount = $allTasks->count();
            $courseSubmissionsCount = $submissions->where('tugas.makul_id', $matkul->id)->count();
            $matkul->progress = $courseTasksCount > 0 ? round(($courseSubmissionsCount / $courseTasksCount) * 100) : 0;

            $tasks = $allTasks->whereNotIn('id', $submittedTugasIds);
            foreach ($tasks as $t) {
                $t->matkul_nama = $matkul->nama_makul;
                $upcoming->push($t);
            }
        }

        // Overall progress
        $overallProgress = $totalTasksCount > 0 ? round(($submissions->count() / $totalTasksCount) * 100) : 0;

        // Average grade
        $graded = $submissions->whereNotNull('nilai');
        $avgGrade = $graded->count() > 0 ? round($graded->avg('nilai')) : 0;

        $maxActiveDate = $user->getMaxActiveDate();
        
        // Prepare events for calendar
        $calendarEvents = [];
        foreach ($upcoming as $t) {
            if ($t->tanggal_akhir_deadline) {
                $calendarEvents[] = [
                    'title' => $t->nama_tugas,
                    'start' => \Carbon\Carbon::parse($t->tanggal_akhir_deadline)->format('Y-m-d'),
                    'url' => route('mahasiswa.courses.show', $t->makul_id)
                ];
            }
        }
        $calendarEventsJson = json_encode($calendarEvents);

        return view('mahasiswa.dashboard', compact('user', 'enrolled', 'submissions', 'certs', 'upcoming', 'avgGrade', 'overallProgress', 'maxActiveDate', 'calendarEventsJson'));
    }
}
