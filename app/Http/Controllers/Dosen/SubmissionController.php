<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\PengerjaanTugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use App\Notifications\GeneralNotification;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $myMatkul = $user->matkulDiampu;
        $allTugas = $myMatkul->flatMap(fn($m) => $m->tugas);
        $filterTugas = $request->query('tugas');

        return view('dosen.submissions', compact('myMatkul', 'allTugas', 'filterTugas'));
    }

    public function grade(Request $request, PengerjaanTugas $submission)
    {
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string|max:2000',
        ]);

        // S2: Verify this submission belongs to the dosen's matkul
        $user = Auth::user();
        $myMatkulIds = $user->matkulDiampu()->pluck('id');
        $tugasBelongsToDosen = $submission->tugas &&
            $myMatkulIds->contains($submission->tugas->makul_id);

        abort_unless(
            $tugasBelongsToDosen,
            Response::HTTP_FORBIDDEN,
            'Anda tidak berhak menilai tugas ini.'
        );

        $submission->update([
            'nilai' => $request->nilai,
            'feedback' => $request->feedback,
        ]);

        // Auto-generate certificate if prodi is completed
        $prodi_id = $submission->tugas->makul->prodi_id ?? null;
        if ($prodi_id && $submission->mahasiswa) {
            $isComplete = $submission->mahasiswa->checkProdiCompletion($prodi_id);
            if ($isComplete) {
                // Check if already has a certificate
                $existingCert = \App\Models\Sertifikat::where('mahasiswa_id', $submission->mahasiswa_id)
                    ->where('prodi_id', $prodi_id)->first();
                
                if (!$existingCert) {
                    \App\Models\Sertifikat::create([
                        'mahasiswa_id' => $submission->mahasiswa_id,
                        'prodi_id' => $prodi_id,
                        'nomor_sertifikat' => 'CERT-PM-' . date('Y') . '-' . strtoupper(uniqid()),
                        'tanggal_terbit' => now(),
                        'status' => 'diterbitkan',
                        'file_sertifikat' => null, // Dynamic HTML
                    ]);
                    
                    // Notify student about certificate
                    $submission->mahasiswa->notify(new GeneralNotification([
                        'title' => 'Sertifikat Kelulusan! 🎓',
                        'message' => 'Selamat! Anda telah menyelesaikan semua tugas dan mendapatkan Sertifikat Kelulusan.',
                        'icon' => 'fas fa-certificate',
                        'color' => 'bg-green-100',
                        'text_color' => 'text-green-600',
                        'url' => route('mahasiswa.certificates')
                    ]));
                }
            }
        }

        // Notify Mahasiswa about grading
        if ($submission->mahasiswa) {
            $submission->mahasiswa->notify(new GeneralNotification([
                'title' => 'Tugas Telah Dinilai',
                'message' => 'Tugas ' . ($submission->tugas->nama_tugas ?? '') . ' Anda telah dinilai: ' . $request->nilai,
                'icon' => 'fas fa-star',
                'color' => 'bg-amber-100',
                'text_color' => 'text-amber-600',
                'url' => route('mahasiswa.grades')
            ]));
        }

        return back()->with('success', 'Nilai berhasil disimpan!');
    }
}
