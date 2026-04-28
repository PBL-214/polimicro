<?php

namespace App\Http\Controllers\AdminPic;

use App\Http\Controllers\Controller;
use App\Models\Makul;
use App\Models\ProdiMikro;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $prodiList = ProdiMikro::all();
        $dosenList = User::dosen()->get();
        $filter = $request->query('prodi');

        $query = Makul::with(['prodi', 'dosen']);
        if ($filter && $filter !== 'all') {
            $query->where('prodi_id', $filter);
        }
        $matkuls = $query->latest()->paginate(10);

        return view('admin-pic.courses', compact('prodiList', 'dosenList', 'matkuls', 'filter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_makul' => 'required|string|max:100',
            'prodi_id' => 'required|exists:prodi_mikro,id',
            'dosen_id' => ['required', 'exists:users,id', function ($attr, $val, $fail) {
                $user = User::find($val);
                if (!$user || $user->role !== 'dosen') {
                    $fail('User yang dipilih bukan dosen.');
                }
            }],
            'deskripsi' => 'nullable|string|max:5000',
            'sks' => 'required|integer|min:1|max:6',
        ]);

        $kode = 'MK' . str_pad(Makul::max('id') + 1, 4, '0', STR_PAD_LEFT);

        Makul::create([
            'kode_makul' => $kode,
            'nama_makul' => $request->nama_makul,
            'prodi_id' => $request->prodi_id,
            'dosen_id' => $request->dosen_id,
            'deskripsi' => $request->deskripsi,
            'sks' => $request->sks,
        ]);

        return back()->with('success', 'Mata kuliah berhasil ditambahkan!');
    }

    public function update(Request $request, Makul $makul)
    {
        $request->validate([
            'nama_makul' => 'required|string|max:100',
            'prodi_id' => 'required|exists:prodi_mikro,id',
            'dosen_id' => ['required', 'exists:users,id', function ($attr, $val, $fail) {
                $user = User::find($val);
                if (!$user || $user->role !== 'dosen') {
                    $fail('User yang dipilih bukan dosen.');
                }
            }],
            'deskripsi' => 'nullable|string|max:5000',
            'sks' => 'required|integer|min:1|max:6',
        ]);

        $makul->update($request->only('nama_makul', 'prodi_id', 'dosen_id', 'deskripsi', 'sks'));
        return back()->with('success', 'Mata kuliah berhasil diperbarui!');
    }

    public function destroy(Makul $makul)
    {
        $makul->delete();
        return back()->with('success', 'Mata kuliah berhasil dihapus!');
    }
}
