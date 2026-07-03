<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $filterMatkul = $request->query('matkul');
        if ($filterMatkul) {
            return redirect()->route('dosen.courses.show', $filterMatkul);
        }
        return redirect()->route('dosen.courses');
    }

    public function store(Request $request)
    {
        $request->validate([
            'makul_id' => 'required|exists:makul,id',
            'nama_materi' => 'required|string|max:100',
            'deskripsi_materi' => 'required|string|max:5000',
            'file_materi' => 'nullable|file|max:2048',
            'youtube_link' => 'nullable|url|max:255',
        ]);

        // Validate file extension manually (avoids fileinfo dependency)
        if ($request->hasFile('file_materi')) {
            $allowed = ['pdf', 'doc', 'docx', 'zip', 'rar'];
            $ext = strtolower($request->file('file_materi')->getClientOriginalExtension());
            if (!in_array($ext, $allowed)) {
                return back()->withErrors(['file_materi' => 'Format file tidak diizinkan. Gunakan: PDF, DOC, DOCX, ZIP, atau RAR.'])->withInput();
            }
        }

        // S1: Verify ownership — dosen can only add to their own matkul
        $user = Auth::user();
        abort_unless(
            $user->matkulDiampu()->where('id', $request->makul_id)->exists(),
            Response::HTTP_FORBIDDEN,
            'Anda tidak berhak mengakses mata kuliah ini.'
        );

        $kode = 'MAT' . str_pad(Materi::max('id') + 1, 4, '0', STR_PAD_LEFT);

        $filePath = null;
        if ($request->hasFile('file_materi')) {
            $filePath = $request->file('file_materi')->store('materials', 'public');
        }

        Materi::create([
            'kode_materi' => $kode,
            'nama_materi' => $request->nama_materi,
            'deskripsi_materi' => $request->deskripsi_materi,
            'file_materi' => $filePath,
            'youtube_link' => $request->youtube_link,
            'makul_id' => $request->makul_id,
        ]);

        return back()->with('success', 'Materi berhasil ditambahkan!');
    }

    public function update(Request $request, Materi $materi)
    {
        $request->validate([
            'makul_id' => 'required|exists:makul,id',
            'nama_materi' => 'required|string|max:100',
            'deskripsi_materi' => 'required|string|max:5000',
            'file_materi' => 'nullable|file|max:2048',
            'youtube_link' => 'nullable|url|max:255',
        ]);

        // S1: Verify ownership
        $user = Auth::user();
        abort_unless(
            $user->matkulDiampu()->where('id', $materi->makul_id)->exists(),
            Response::HTTP_FORBIDDEN,
            'Anda tidak berhak mengubah materi ini.'
        );

        $filePath = $materi->file_materi;
        if ($request->hasFile('file_materi')) {
            $allowed = ['pdf', 'doc', 'docx', 'zip', 'rar'];
            $ext = strtolower($request->file('file_materi')->getClientOriginalExtension());
            if (!in_array($ext, $allowed)) {
                return back()->withErrors(['file_materi' => 'Format file tidak diizinkan.'])->withInput();
            }
            
            // Delete old file if exists
            if ($filePath && \Illuminate\Support\Facades\Storage::disk('public')->exists($filePath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($filePath);
            }
            
            $filePath = $request->file('file_materi')->store('materials', 'public');
        }

        $materi->update([
            'makul_id' => $request->makul_id,
            'nama_materi' => $request->nama_materi,
            'deskripsi_materi' => $request->deskripsi_materi,
            'file_materi' => $filePath,
            'youtube_link' => $request->youtube_link,
        ]);
        return back()->with('success', 'Materi berhasil diperbarui!');
    }

    public function destroy(Materi $materi)
    {
        // S1: Verify ownership
        $user = Auth::user();
        abort_unless(
            $user->matkulDiampu()->where('id', $materi->makul_id)->exists(),
            Response::HTTP_FORBIDDEN,
            'Anda tidak berhak menghapus materi ini.'
        );

        $materi->delete();
        return back()->with('success', 'Materi berhasil dihapus!');
    }
}
