<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AssignmentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $myMatkul = $user->matkulDiampu;
        return view('dosen.assignments', compact('myMatkul'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'makul_id' => 'required|exists:makul,id',
            'nama_tugas' => 'required|string|max:100',
            'deskripsi_tugas' => 'required|string|max:5000',
            'tanggal_akhir_deadline' => 'required|date|after_or_equal:today',
            'max_nilai' => 'required|integer|min:1|max:100',
            'file_tugas' => 'nullable|file|max:2048',
        ]);

        // Validate file extension manually
        if ($request->hasFile('file_tugas')) {
            $allowed = ['pdf', 'doc', 'docx', 'zip', 'rar'];
            $ext = strtolower($request->file('file_tugas')->getClientOriginalExtension());
            if (!in_array($ext, $allowed)) {
                return back()->withErrors(['file_tugas' => 'Format file tidak diizinkan. Gunakan: PDF, DOC, DOCX, ZIP, atau RAR.'])->withInput();
            }
        }

        // S1: Verify ownership
        $user = Auth::user();
        abort_unless(
            $user->matkulDiampu()->where('id', $request->makul_id)->exists(),
            Response::HTTP_FORBIDDEN,
            'Anda tidak berhak menambah tugas di mata kuliah ini.'
        );

        $kode = 'TGS' . str_pad(Tugas::max('id') + 1, 4, '0', STR_PAD_LEFT);

        $filePath = null;
        if ($request->hasFile('file_tugas')) {
            $filePath = $request->file('file_tugas')->store('assignments', 'public');
        }

        Tugas::create([
            'kode_tugas' => $kode,
            'nama_tugas' => $request->nama_tugas,
            'deskripsi_tugas' => $request->deskripsi_tugas,
            'file_tugas' => $filePath,
            'tanggal_akhir_deadline' => $request->tanggal_akhir_deadline,
            'max_nilai' => $request->max_nilai,
            'makul_id' => $request->makul_id,
        ]);

        return back()->with('success', 'Tugas berhasil dibuat!');
    }

    public function update(Request $request, Tugas $tugas)
    {
        $request->validate([
            'makul_id' => 'required|exists:makul,id',
            'nama_tugas' => 'required|string|max:100',
            'deskripsi_tugas' => 'required|string|max:5000',
            'tanggal_akhir_deadline' => 'required|date',
            'max_nilai' => 'required|integer|min:1|max:100',
            'file_tugas' => 'nullable|file|max:2048',
        ]);

        // S1: Verify ownership
        $user = Auth::user();
        abort_unless(
            $user->matkulDiampu()->where('id', $tugas->makul_id)->exists(),
            Response::HTTP_FORBIDDEN,
            'Anda tidak berhak mengubah tugas ini.'
        );

        $filePath = $tugas->file_tugas;
        if ($request->hasFile('file_tugas')) {
            // Delete old file if exists
            if ($filePath && \Illuminate\Support\Facades\Storage::disk('public')->exists($filePath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('file_tugas')->store('assignments', 'public');
        }

        $tugas->update([
            'makul_id' => $request->makul_id,
            'nama_tugas' => $request->nama_tugas,
            'deskripsi_tugas' => $request->deskripsi_tugas,
            'tanggal_akhir_deadline' => $request->tanggal_akhir_deadline,
            'max_nilai' => $request->max_nilai,
            'file_tugas' => $filePath,
        ]);
        return back()->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroy(Tugas $tugas)
    {
        // S1: Verify ownership
        $user = Auth::user();
        abort_unless(
            $user->matkulDiampu()->where('id', $tugas->makul_id)->exists(),
            Response::HTTP_FORBIDDEN,
            'Anda tidak berhak menghapus tugas ini.'
        );

        $tugas->delete();
        return back()->with('success', 'Tugas berhasil dihapus!');
    }
}
