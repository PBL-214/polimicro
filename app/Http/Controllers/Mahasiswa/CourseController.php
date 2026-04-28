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
        return view('mahasiswa.courses', compact('enrolled'));
    }
}
