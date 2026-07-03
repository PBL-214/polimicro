<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $enrolled = $user->getEnrolledMatkul();
        $submissions = $user->submissions()->with('tugas.makul')->get();
        
        foreach ($enrolled as $matkul) {
            $courseTasksCount = $matkul->tugas()->count();
            $courseSubmissionsCount = $submissions->where('tugas.makul_id', $matkul->id)->count();
            $matkul->progress = $courseTasksCount > 0 ? round(($courseSubmissionsCount / $courseTasksCount) * 100) : 0;
        }

        return view('mahasiswa.courses', compact('enrolled'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $enrolled = $user->getEnrolledMatkul();
        $course = $enrolled->firstWhere('id', $id);
        
        if (!$course) {
            abort(404, 'Mata kuliah tidak ditemukan atau Anda tidak terdaftar.');
        }
        
        // Get materials
        $materials = $course->materi()->get();
        
        // Get all tasks for this course
        $assignments = $course->tugas()->get();
        
        // Get submissions by this student for this course's assignments
        $submissions = $user->submissions()->whereIn('tugas_id', $assignments->pluck('id'))->get();
        
        return view('mahasiswa.course-detail', compact('course', 'materials', 'assignments', 'submissions'));
    }
}
