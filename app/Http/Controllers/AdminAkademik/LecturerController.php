<?php

namespace App\Http\Controllers\AdminAkademik;

use App\Http\Controllers\Controller;
use App\Models\ProdiMikro;
use App\Models\User;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    public function index()
    {
        $dosenList = User::dosen()->latest()->paginate(5);
        $prodiList = ProdiMikro::aktif()->orderBy('nama_prodi')->get();
        return view('admin-akademik.lecturers', compact('dosenList', 'prodiList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'nip' => 'nullable|string|max:30',
            'phone' => 'nullable|string|max:20',
            'homebase' => 'nullable|string|max:100|exists:prodi_mikro,nama_prodi',
            'address' => 'nullable|string|max:500',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = 'dosen123';
        $user->nip = $request->nip;
        $user->phone = $request->phone;
        $user->homebase = $request->homebase;
        $user->address = $request->address;
        $user->status = 'aktif';
        $user->role = 'dosen';
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
            'homebase' => 'nullable|string|max:100|exists:prodi_mikro,nama_prodi',
            'address' => 'nullable|string|max:500',
        ]);

        $dosen->update($request->only('name', 'email', 'nip', 'phone', 'homebase', 'address'));
        return back()->with('success', 'Data dosen berhasil diperbarui!');
    }

    public function destroy(User $dosen)
    {
        abort_unless($dosen->role === 'dosen', 403, 'User ini bukan dosen.');

        $dosen->delete();
        return back()->with('success', 'Dosen berhasil dihapus!');
    }
}
