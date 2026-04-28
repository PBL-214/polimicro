<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $myMatkul = $user->matkulDiampu()->with('prodi')->paginate(5);
        return view('dosen.students', compact('myMatkul'));
    }
}
