<?php

namespace App\Http\Controllers\AdminAkademik;

use App\Http\Controllers\Controller;
use App\Models\ProdiMikro;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $prodiList = ProdiMikro::latest()->paginate(5);
        return view('admin-akademik.programs', compact('prodiList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'durasi' => 'required|string|max:50',
            'icon' => 'nullable|string|max:10',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $kode = 'PRD' . str_pad(ProdiMikro::max('id') + 1, 3, '0', STR_PAD_LEFT);

        ProdiMikro::create([
            'kode_prodi' => $kode,
            'nama_prodi' => $request->nama_prodi,
            'deskripsi' => $request->deskripsi,
            'durasi' => $request->durasi,
            'icon' => $request->icon ?: '📚',
            'status' => $request->status,
        ]);

        return back()->with('success', 'Program studi berhasil ditambahkan!');
    }

    public function update(Request $request, ProdiMikro $prodi)
    {
        $request->validate([
            'nama_prodi' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'durasi' => 'required|string|max:50',
            'icon' => 'nullable|string|max:10',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $prodi->update($request->only('nama_prodi', 'deskripsi', 'durasi', 'icon', 'status'));
        return back()->with('success', 'Program studi berhasil diperbarui!');
    }

    public function destroy(ProdiMikro $prodi)
    {
        $prodi->delete();
        return back()->with('success', 'Program studi berhasil dihapus!');
    }
}
