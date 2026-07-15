<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Pendaftaran;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function store(Request $request, $courseId)
    {
        $course = Auth::user()->matkulDiampu()->with('prodi')->findOrFail($courseId);
        $request->validate([
            'title' => 'required|string|max:200',
            'body' => 'required|string|max:5000',
        ]);

        $announcement = Announcement::create([
            'makul_id' => $courseId,
            'user_id' => Auth::id(),
            'title' => $request->title,
            'body' => $request->body,
            'published_at' => now(),
        ]);

        // Notify all enrolled students
        $studentIds = Pendaftaran::where('prodi_id', $course->prodi_id)
            ->where('status', 'diterima')
            ->pluck('mahasiswa_id');
        $students = User::whereIn('id', $studentIds)->get();

        foreach ($students as $student) {
            $student->notify(new GeneralNotification([
                'title' => 'Pengumuman Baru: ' . $course->nama_makul,
                'message' => $request->title,
                'icon' => 'fas fa-bullhorn',
                'color' => 'bg-yellow-100',
                'text_color' => 'text-yellow-600',
                'url' => route('mahasiswa.courses.show', $courseId),
            ]));
        }

        return back()->with('success', 'Pengumuman berhasil dipublikasikan!');
    }

    public function destroy($courseId, $announcementId)
    {
        Auth::user()->matkulDiampu()->findOrFail($courseId);
        Announcement::findOrFail($announcementId)->delete();

        return back()->with('success', 'Pengumuman berhasil dihapus!');
    }
}
