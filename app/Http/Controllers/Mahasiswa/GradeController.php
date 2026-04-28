<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $submissions = $user->submissions()->with(['tugas.makul'])->latest()->paginate(5);
        
        $allSubmissions = $user->submissions()->get();
        $gradedCount = $allSubmissions->whereNotNull('nilai')->count();
        $avg = $gradedCount > 0 ? round($allSubmissions->whereNotNull('nilai')->avg('nilai')) : 0;

        return view('mahasiswa.grades', compact('submissions', 'gradedCount', 'avg'));
    }
}
