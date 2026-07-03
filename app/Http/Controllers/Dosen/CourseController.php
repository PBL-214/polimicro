<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $myMatkul = $user->matkulDiampu()->with('prodi')->paginate(10);
        return view('dosen.courses', compact('myMatkul'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $course = $user->matkulDiampu()->where('id', $id)->firstOrFail();
        
        $materials = $course->materi()->get();
        $assignments = $course->tugas()->withCount('submissions')->get();
        
        return view('dosen.course-detail', compact('course', 'materials', 'assignments'));
    }
}
