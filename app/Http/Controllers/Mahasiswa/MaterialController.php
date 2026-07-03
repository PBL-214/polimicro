<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $filterMatkul = $request->query('matkul');
        if ($filterMatkul) {
            return redirect()->route('mahasiswa.courses.show', $filterMatkul);
        }
        return redirect()->route('mahasiswa.courses');
    }
}
