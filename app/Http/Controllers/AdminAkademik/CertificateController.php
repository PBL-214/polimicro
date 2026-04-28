<?php

namespace App\Http\Controllers\AdminAkademik;

use App\Http\Controllers\Controller;
use App\Models\ProdiMikro;
use App\Models\Sertifikat;
use App\Models\User;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        $certs = Sertifikat::with(['mahasiswa', 'prodi'])->latest()->get();
        $mahasiswaList = User::mahasiswa()->where('status', 'aktif')->get();
        $prodiList = ProdiMikro::aktif()->get();

        return view('admin-akademik.certificates', compact('certs', 'mahasiswaList', 'prodiList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id',
            'prodi_id' => 'required|exists:prodi_mikro,id',
            'nomor_sertifikat' => 'required|string|unique:sertifikat,nomor_sertifikat',
            'tanggal_terbit' => 'required|date',
            'file_sertifikat' => 'required|file|max:2048',
        ]);

        // Validate file extension manually (avoids fileinfo dependency)
        $allowed = ['pdf', 'jpg', 'jpeg', 'png'];
        $ext = strtolower($request->file('file_sertifikat')->getClientOriginalExtension());
        if (!in_array($ext, $allowed)) {
            return back()->withErrors(['file_sertifikat' => 'Format file tidak diizinkan. Gunakan: PDF, JPG, atau PNG.'])->withInput();
        }

        $filePath = null;
        if ($request->hasFile('file_sertifikat')) {
            $filePath = $request->file('file_sertifikat')->store('certificates', 'public');
        }

        Sertifikat::create([
            'mahasiswa_id' => $request->mahasiswa_id,
            'prodi_id' => $request->prodi_id,
            'nomor_sertifikat' => $request->nomor_sertifikat,
            'tanggal_terbit' => $request->tanggal_terbit,
            'file_sertifikat' => $filePath,
            'status' => 'diterbitkan',
        ]);

        return back()->with('success', 'Sertifikat berhasil diterbitkan!');
    }

    public function destroy(Sertifikat $sertifikat)
    {
        $sertifikat->delete();
        return back()->with('success', 'Sertifikat berhasil dihapus!');
    }
}
