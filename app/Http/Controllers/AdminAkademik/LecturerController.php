<?php

namespace App\Http\Controllers\AdminAkademik;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    public function index()
    {
        $dosenList = User::dosen()->get();
        return view('admin-akademik.lecturers', compact('dosenList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'nip' => 'nullable|string|max:30',
            'phone' => 'nullable|string|max:20',
            'bidang' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => 'dosen123',
            'nip' => $request->nip,
            'phone' => $request->phone,
            'bidang' => $request->bidang,
            'address' => $request->address,
            'status' => 'aktif',
        ]);
        $user->role = 'dosen'; // Explicitly set — not mass-assignable
        $user->save();

        return back()->with('success', 'Dosen berhasil ditambahkan!');
    }

    public function update(Request $request, User $dosen)
    {
        abort_unless($dosen->role === 'dosen', 403, 'User ini bukan dosen.');

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $dosen->id,
            'nip' => 'nullable|string|max:30',
            'phone' => 'nullable|string|max:20',
            'bidang' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
        ]);

        $dosen->update($request->only('name', 'email', 'nip', 'phone', 'bidang', 'address'));
        return back()->with('success', 'Data dosen berhasil diperbarui!');
    }

    public function destroy(User $dosen)
    {
        abort_unless($dosen->role === 'dosen', 403, 'User ini bukan dosen.');

        $dosen->delete();
        return back()->with('success', 'Dosen berhasil dihapus!');
    }
}
