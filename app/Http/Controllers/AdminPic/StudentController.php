<?php

namespace App\Http\Controllers\AdminPic;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\ProdiMikro;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $prodiList = ProdiMikro::all();
        $prodiFilter = $request->query('prodi');
        $search = $request->query('search');

        $query = User::mahasiswa();

        if ($prodiFilter && $prodiFilter !== 'all') {
            $enrolledIds = Pendaftaran::diterima()->where('prodi_id', $prodiFilter)->pluck('mahasiswa_id');
            $query->whereIn('id', $enrolledIds);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $students = $query->latest()->paginate(10);

        return view('admin-pic.students', compact('prodiList', 'students', 'prodiFilter', 'search'));
    }

    public function exportCsv()
    {
        $students = User::mahasiswa()->with(['pendaftaran.prodi'])->get();
        $filename = "data_mahasiswa_" . date('Ymd') . ".csv";
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // CSV Header
        fputcsv($handle, ['NIM', 'Nama', 'Email', 'Program Studi', 'Status']);

        foreach ($students as $s) {
            $prodiNames = $s->pendaftaran->map(fn($p) => $p->prodi->nama_prodi ?? '-')->implode(', ');
            fputcsv($handle, [
                $s->nim,
                $s->name,
                $s->email,
                $prodiNames,
                $s->status
            ]);
        }

        fclose($handle);
        exit;
    }
}
