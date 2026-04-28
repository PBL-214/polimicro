<?php

namespace App\Http\Controllers\AdminPic;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Http\Request;

use App\Notifications\GeneralNotification;

class VerificationController extends Controller
{
    public function index()
    {
        $pendingList = Pendaftaran::pending()->with(['mahasiswa', 'prodi'])->paginate(5, ['*'], 'pendingPage');
        $historyList = Pendaftaran::where('status', '!=', 'pending')->with(['mahasiswa', 'prodi'])->latest()->paginate(5, ['*'], 'historyPage');

        return view('admin-pic.verification', compact('pendingList', 'historyList'));
    }

    public function verify(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate(['status' => 'required|in:diterima,ditolak']);

        $pendaftaran->update(['status' => $request->status]);

        if ($request->status === 'diterima') {
            $user = User::find($pendaftaran->mahasiswa_id);
            if ($user && $user->status === 'pending') {
                $user->status = 'aktif';
                $user->save();
            }
        }

        // Notify Mahasiswa
        if ($pendaftaran->mahasiswa) {
            $title = $request->status === 'diterima' ? 'Pendaftaran Diterima! 🎉' : 'Pendaftaran Ditolak';
            $message = $request->status === 'diterima' 
                ? 'Selamat! Anda telah diterima di prodi ' . ($pendaftaran->prodi->nama_prodi ?? '')
                : 'Mohon maaf, pendaftaran Anda di prodi ' . ($pendaftaran->prodi->nama_prodi ?? '') . ' belum dapat kami terima.';
            
            $pendaftaran->mahasiswa->notify(new GeneralNotification([
                'title' => $title,
                'message' => $message,
                'icon' => $request->status === 'diterima' ? 'fas fa-check-circle' : 'fas fa-times-circle',
                'color' => $request->status === 'diterima' ? 'bg-cyan-100' : 'bg-red-100',
                'text_color' => $request->status === 'diterima' ? 'text-cyan-600' : 'text-red-600',
                'url' => route('mahasiswa.dashboard')
            ]));
        }

        $msg = $request->status === 'diterima' ? 'Mahasiswa diterima!' : 'Pendaftaran ditolak';
        return back()->with('success', $msg);
    }
}
