<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $myMatkul = $user->matkulDiampu()->with('prodi')->get();
        return view('dosen.courses', compact('myMatkul'));
    }
}
