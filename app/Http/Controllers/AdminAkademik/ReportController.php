<?php

namespace App\Http\Controllers\AdminAkademik;

use App\Http\Controllers\Controller;
use App\Models\Makul;
use App\Models\PengerjaanTugas;
use App\Models\Pendaftaran;
use App\Models\ProdiMikro;
use App\Models\User;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $programs = ProdiMikro::with('makul')->where('status', 'aktif')->get();
        return view('admin-akademik.reports.index', compact('programs'));
    }

    public function courseReport($makulId)
    {
        $makul = Makul::with(['prodi', 'dosen', 'tugas'])->findOrFail($makulId);

        // Get enrolled students
        $studentIds = Pendaftaran::where('prodi_id', $makul->prodi_id)
            ->where('status', 'diterima')
            ->pluck('mahasiswa_id');
        $students = User::whereIn('id', $studentIds)->orderBy('name')->get();

        // Get all tugas and quiz data
        $tugasIds = $makul->tugas->pluck('id');
        $submissions = PengerjaanTugas::whereIn('tugas_id', $tugasIds)->get();
        
        $quizAttempts = QuizAttempt::whereHas('quiz', function($q) use ($makulId) {
            $q->where('makul_id', $makulId);
        })->get();

        // Build report data
        $reportData = [];
        foreach ($students as $student) {
            $studentSubs = $submissions->where('mahasiswa_id', $student->id);
            $studentQuizAttempts = $quizAttempts->where('user_id', $student->id);

            $tugasGrades = $studentSubs->whereNotNull('nilai')->pluck('nilai');
            $quizScores = $studentQuizAttempts->pluck('score');

            $allGrades = $tugasGrades->merge($quizScores);

            $reportData[] = [
                'student' => $student,
                'tugas_submitted' => $studentSubs->count(),
                'tugas_total' => $makul->tugas->count(),
                'avg_tugas' => $tugasGrades->count() > 0 ? round($tugasGrades->avg(), 1) : '-',
                'quiz_taken' => $studentQuizAttempts->count(),
                'avg_quiz' => $quizScores->count() > 0 ? round($quizScores->avg(), 1) : '-',
                'avg_overall' => $allGrades->count() > 0 ? round($allGrades->avg(), 1) : '-',
            ];
        }

        // Statistics
        $allAvgs = collect($reportData)->pluck('avg_overall')->filter(fn($v) => $v !== '-')->map(fn($v) => (float) $v);
        $stats = [
            'avg' => $allAvgs->count() > 0 ? round($allAvgs->avg(), 1) : 0,
            'max' => $allAvgs->count() > 0 ? $allAvgs->max() : 0,
            'min' => $allAvgs->count() > 0 ? $allAvgs->min() : 0,
            'total_students' => count($students),
        ];

        return view('admin-akademik.reports.course-report', compact('makul', 'reportData', 'stats'));
    }

    public function exportCsv($makulId)
    {
        $makul = Makul::with(['prodi', 'tugas'])->findOrFail($makulId);
        $studentIds = Pendaftaran::where('prodi_id', $makul->prodi_id)
            ->where('status', 'diterima')
            ->pluck('mahasiswa_id');
        $students = User::whereIn('id', $studentIds)->orderBy('name')->get();

        $tugasIds = $makul->tugas->pluck('id');
        $submissions = PengerjaanTugas::whereIn('tugas_id', $tugasIds)->get();
        $quizAttempts = QuizAttempt::whereHas('quiz', function($q) use ($makulId) {
            $q->where('makul_id', $makulId);
        })->get();

        $filename = 'rekap_nilai_' . str_replace(' ', '_', $makul->nama_makul) . '_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($students, $submissions, $makul, $quizAttempts) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'NIM', 'Nama', 'Tugas Dikumpul', 'Rata-rata Tugas', 'Kuis Dikerjakan', 'Rata-rata Kuis', 'Rata-rata Keseluruhan']);

            foreach ($students as $i => $student) {
                $studentSubs = $submissions->where('mahasiswa_id', $student->id);
                $studentQuiz = $quizAttempts->where('user_id', $student->id);
                $tugasGrades = $studentSubs->whereNotNull('nilai')->pluck('nilai');
                $quizScores = $studentQuiz->pluck('score');
                $allGrades = $tugasGrades->merge($quizScores);

                fputcsv($file, [
                    $i + 1,
                    $student->nim,
                    $student->name,
                    $studentSubs->count() . '/' . $makul->tugas->count(),
                    $tugasGrades->count() > 0 ? round($tugasGrades->avg(), 1) : '-',
                    $studentQuiz->count(),
                    $quizScores->count() > 0 ? round($quizScores->avg(), 1) : '-',
                    $allGrades->count() > 0 ? round($allGrades->avg(), 1) : '-',
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
