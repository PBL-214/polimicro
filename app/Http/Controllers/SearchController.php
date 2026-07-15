<?php

namespace App\Http\Controllers;

use App\Models\ForumDiscussion;
use App\Models\Makul;
use App\Models\Materi;
use App\Models\ProdiMikro;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $user = Auth::user();
        $results = [];

        if ($user->isMahasiswa()) {
            // Search courses
            $prodiIds = $user->enrolledProdi()->pluck('prodi_id');
            $courses = Makul::whereIn('prodi_id', $prodiIds)
                ->where('nama_makul', 'like', "%{$query}%")
                ->limit(5)->get();
            foreach ($courses as $c) {
                $results[] = ['type' => 'Mata Kuliah', 'title' => $c->nama_makul, 'url' => route('mahasiswa.courses.show', $c->id), 'icon' => 'fas fa-book-open'];
            }

            // Search materials
            $makulIds = Makul::whereIn('prodi_id', $prodiIds)->pluck('id');
            $materials = Materi::whereIn('makul_id', $makulIds)
                ->where('nama_materi', 'like', "%{$query}%")
                ->limit(5)->get();
            foreach ($materials as $m) {
                $results[] = ['type' => 'Materi', 'title' => $m->nama_materi, 'url' => route('mahasiswa.courses.show', $m->makul_id), 'icon' => 'fas fa-file-alt'];
            }

        } elseif ($user->isDosen()) {
            // Search courses
            $courses = $user->matkulDiampu()->where('nama_makul', 'like', "%{$query}%")->limit(5)->get();
            foreach ($courses as $c) {
                $results[] = ['type' => 'Mata Kuliah', 'title' => $c->nama_makul, 'url' => route('dosen.courses.show', $c->id), 'icon' => 'fas fa-book-open'];
            }

            // Search students
            $students = User::mahasiswa()->where('name', 'like', "%{$query}%")->orWhere('nim', 'like', "%{$query}%")->limit(5)->get();
            foreach ($students as $s) {
                $results[] = ['type' => 'Mahasiswa', 'title' => $s->name . ' (' . $s->nim . ')', 'url' => route('dosen.students'), 'icon' => 'fas fa-user-graduate'];
            }

        } elseif ($user->isAdminPic() || $user->isAdminAkademik()) {
            // Search students
            $students = User::mahasiswa()->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")->orWhere('nim', 'like', "%{$query}%");
            })->limit(5)->get();
            foreach ($students as $s) {
                $route = $user->isAdminPic() ? route('admin-pic.students') : route('admin-akademik.lecturers');
                $results[] = ['type' => 'Mahasiswa', 'title' => $s->name . ' (' . $s->nim . ')', 'url' => $route, 'icon' => 'fas fa-user-graduate'];
            }

            // Search programs
            $programs = ProdiMikro::where('nama_prodi', 'like', "%{$query}%")->limit(5)->get();
            foreach ($programs as $p) {
                $route = $user->isAdminAkademik() ? route('admin-akademik.programs') : route('admin-pic.courses');
                $results[] = ['type' => 'Program', 'title' => $p->nama_prodi, 'url' => $route, 'icon' => 'fas fa-university'];
            }

            // Search lecturers (admin akademik only)
            if ($user->isAdminAkademik()) {
                $lecturers = User::dosen()->where('name', 'like', "%{$query}%")->limit(5)->get();
                foreach ($lecturers as $l) {
                    $results[] = ['type' => 'Dosen', 'title' => $l->name, 'url' => route('admin-akademik.lecturers'), 'icon' => 'fas fa-chalkboard-teacher'];
                }
            }
        }

        return response()->json(['results' => $results]);
    }
}
