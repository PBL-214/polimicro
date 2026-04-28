<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $submissions = $user->submissions()->with(['tugas.makul'])->get();
        $graded = $submissions->whereNotNull('nilai');
        $avg = $graded->count() > 0 ? round($graded->avg('nilai')) : 0;

        return view('mahasiswa.grades', compact('submissions', 'graded', 'avg'));
    }
}
