<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceRecord;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index($courseId)
    {
        $course = Auth::user()->matkulDiampu()->findOrFail($courseId);
        $attendances = Attendance::where('makul_id', $courseId)
            ->with('records')
            ->orderBy('pertemuan_ke')
            ->get();

        return view('dosen.attendances.index', compact('course', 'attendances'));
    }

    public function create($courseId)
    {
        $course = Auth::user()->matkulDiampu()->with('prodi')->findOrFail($courseId);
        $studentIds = Pendaftaran::where('prodi_id', $course->prodi_id)
            ->where('status', 'diterima')
            ->pluck('mahasiswa_id');
        $students = User::whereIn('id', $studentIds)->orderBy('name')->get();

        $nextPertemuan = Attendance::where('makul_id', $courseId)->max('pertemuan_ke') + 1;

        return view('dosen.attendances.create', compact('course', 'students', 'nextPertemuan'));
    }

    public function store(Request $request, $courseId)
    {
        Auth::user()->matkulDiampu()->findOrFail($courseId);
        $request->validate([
            'pertemuan_ke' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string|max:500',
            'status' => 'required|array',
            'status.*' => 'in:hadir,izin,sakit,alpha',
        ]);

        $attendance = Attendance::create([
            'makul_id' => $courseId,
            'pertemuan_ke' => $request->pertemuan_ke,
            'tanggal' => $request->tanggal,
            'catatan' => $request->catatan,
            'created_by' => Auth::id(),
        ]);

        foreach ($request->status as $studentId => $status) {
            AttendanceRecord::create([
                'attendance_id' => $attendance->id,
                'mahasiswa_id' => $studentId,
                'status' => $status,
            ]);
        }

        return redirect()->route('dosen.courses.attendances.index', $courseId)
            ->with('success', 'Absensi pertemuan ke-' . $request->pertemuan_ke . ' berhasil disimpan!');
    }

    public function show($courseId, $attendanceId)
    {
        $course = Auth::user()->matkulDiampu()->findOrFail($courseId);
        $attendance = Attendance::with('records.mahasiswa')->findOrFail($attendanceId);

        return view('dosen.attendances.show', compact('course', 'attendance'));
    }

    public function update(Request $request, $courseId, $attendanceId)
    {
        Auth::user()->matkulDiampu()->findOrFail($courseId);
        $attendance = Attendance::findOrFail($attendanceId);

        $request->validate([
            'status' => 'required|array',
            'status.*' => 'in:hadir,izin,sakit,alpha',
        ]);

        foreach ($request->status as $studentId => $status) {
            AttendanceRecord::where('attendance_id', $attendanceId)
                ->where('mahasiswa_id', $studentId)
                ->update(['status' => $status]);
        }

        return back()->with('success', 'Absensi berhasil diperbarui!');
    }
}
