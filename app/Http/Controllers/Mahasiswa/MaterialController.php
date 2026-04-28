<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $enrolled = $user->getEnrolledMatkul();
        $filterMatkul = $request->query('matkul');

        return view('mahasiswa.materials', compact('enrolled', 'filterMatkul'));
    }
}
