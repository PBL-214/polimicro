<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceRecord;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index($courseId)
    {
        $user = Auth::user();
        $enrolled = $user->getEnrolledMatkul();
        $course = $enrolled->firstWhere('id', $courseId);
        if (!$course) abort(404, 'Mata kuliah tidak ditemukan.');

        $attendances = Attendance::where('makul_id', $courseId)->orderBy('pertemuan_ke')->get();
        $records = AttendanceRecord::whereIn('attendance_id', $attendances->pluck('id'))
            ->where('mahasiswa_id', $user->id)
            ->get()
            ->keyBy('attendance_id');

        $stats = [
            'hadir' => $records->where('status', 'hadir')->count(),
            'izin' => $records->where('status', 'izin')->count(),
            'sakit' => $records->where('status', 'sakit')->count(),
            'alpha' => $records->where('status', 'alpha')->count(),
            'total' => $attendances->count()
        ];
        
        $percentage = $stats['total'] > 0 ? round(($stats['hadir'] / $stats['total']) * 100) : 0;

        return view('mahasiswa.attendances.index', compact('course', 'attendances', 'records', 'stats', 'percentage'));
    }
}
