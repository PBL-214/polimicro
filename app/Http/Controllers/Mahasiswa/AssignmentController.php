<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\PengerjaanTugas;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $enrolled = $user->getEnrolledMatkul();
        $submissions = $user->submissions;
        $filterMatkul = $request->query('matkul');

        return view('mahasiswa.assignments', compact('enrolled', 'submissions', 'filterMatkul'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'tugas_id' => 'required|exists:tugas,id',
        ]);

        $user = Auth::user();

        // Security: verify this tugas belongs to an enrolled matkul
        $tugas = Tugas::findOrFail($request->tugas_id);
        $enrolledMatkulIds = $user->getEnrolledMatkul()->pluck('id');
        abort_unless(
            $enrolledMatkulIds->contains($tugas->makul_id),
            403,
            'Anda tidak terdaftar di mata kuliah untuk tugas ini.'
        );

        // Prevent duplicate submission
        $existing = PengerjaanTugas::where('mahasiswa_id', $user->id)
            ->where('tugas_id', $request->tugas_id)
            ->first();

        if ($existing) {
            return back()->with('warning', 'Anda sudah mengumpulkan tugas ini!');
        }

        $fileName = 'submission_' . $user->nim . '_' . time() . '.pdf';

        if ($request->hasFile('file')) {
            $request->validate(['file' => 'required|file|max:2048']);
            $allowed = ['pdf', 'doc', 'docx', 'zip', 'rar', 'py', 'ipynb', 'xlsx', 'html'];
            $ext = strtolower($request->file('file')->getClientOriginalExtension());
            if (!in_array($ext, $allowed)) {
                return back()->withErrors(['file' => 'Format file tidak diizinkan.'])->withInput();
            }
            $fileName = $request->file('file')->store('submissions', 'public');
        } else {
            return back()->withErrors(['file' => 'File wajib diunggah.'])->withInput();
        }

        $submission = PengerjaanTugas::create([
            'mahasiswa_id' => $user->id,
            'tugas_id' => $request->tugas_id,
            'file_dikumpul' => $fileName,
            'waktu_kumpul' => now(),
        ]);

        // Notify Dosen
        if ($tugas->makul && $tugas->makul->dosen) {
            $tugas->makul->dosen->notify(new GeneralNotification([
                'title' => 'Pengumpulan Tugas Baru',
                'message' => $user->name . ' telah mengumpulkan tugas ' . $tugas->nama_tugas,
                'icon' => 'fas fa-inbox',
                'color' => 'bg-emerald-100',
                'text_color' => 'text-emerald-600',
                'url' => route('dosen.submissions', ['tugas' => $tugas->id])
            ]));
        }

        return back()->with('success', 'Tugas berhasil dikumpulkan!');
    }
}
