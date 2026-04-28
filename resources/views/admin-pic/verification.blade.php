@extends('layouts.dashboard', ['activePage' => 'verification'])
@section('title', 'Verifikasi Mahasiswa - Admin PIC - Polimicro')
@section('content')
<h1 class="text-2xl font-bold text-gray-900 mb-2">Verifikasi Mahasiswa</h1>
<p class="text-gray-500 mb-6">Verifikasi pendaftaran mahasiswa baru</p>
{{-- Pending --}}
<div class="bg-white rounded-3xl border border-slate-100 mb-8 overflow-hidden shadow-sm">
    <div class="p-6 border-b border-slate-50 flex items-center justify-between bg-slate-50/50">
        <h3 class="font-bold text-slate-900 flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
            </span>
            Menunggu Verifikasi
        </h3>
        <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-[10px] font-bold uppercase tracking-wider">{{ $pendingList->count() }} Permintaan</span>
    </div>
    <div class="overflow-x-auto"><table class="w-full text-sm">
        <thead><tr class="bg-slate-50/30 border-b border-slate-100"><th class="px-5 py-3 text-left font-bold text-slate-600 uppercase tracking-wider text-[10px]">Mahasiswa</th><th class="px-5 py-3 text-left font-bold text-slate-600 uppercase tracking-wider text-[10px]">Program Studi</th><th class="px-5 py-3 text-left font-bold text-slate-600 uppercase tracking-wider text-[10px]">Tanggal</th><th class="px-5 py-3 text-center font-bold text-slate-600 uppercase tracking-wider text-[10px]">Aksi</th></tr></thead>
        <tbody class="divide-y divide-slate-50">
        @forelse($pendingList as $p)
            <tr class="hover:bg-slate-50/80 transition group">
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-cyan-100 flex items-center justify-center text-[10px] font-bold text-cyan-700 transition-transform group-hover:scale-110 shadow-inner">{{ $p->mahasiswa ? $p->mahasiswa->getInitials() : '?' }}</div>
                        <div>
                            <p class="font-bold text-slate-800 text-sm">{{ $p->mahasiswa->name ?? '-' }}</p>
                            <p class="text-[10px] text-slate-400 font-medium">{{ $p->mahasiswa->email ?? '' }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-4"><span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 text-[10px] font-bold uppercase tracking-tighter">{{ $p->prodi->nama_prodi ?? '-' }}</span></td>
                <td class="px-5 py-4 text-slate-400 text-[10px] font-bold">{{ $p->registered_at?->format('d M Y') ?? '-' }}</td>
                <td class="px-5 py-4 text-center">
                    <div class="row-actions flex gap-2 justify-center">
                        <form method="POST" action="{{ route('admin-pic.verification.verify', $p) }}">@csrf @method('PUT')<input type="hidden" name="status" value="diterima"><button class="px-4 py-2 bg-emerald-500 text-white rounded-xl text-[10px] font-bold hover:bg-emerald-600 transition shadow-lg shadow-emerald-500/20"><i class="fas fa-check mr-1"></i>TERIMA</button></form>
                        <form method="POST" action="{{ route('admin-pic.verification.verify', $p) }}">@csrf @method('PUT')<input type="hidden" name="status" value="ditolak"><button class="px-4 py-2 bg-white text-red-600 border border-red-100 rounded-xl text-[10px] font-bold hover:bg-red-50 transition"><i class="fas fa-times mr-1"></i>TOLAK</button></form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="px-5 py-16 text-center text-slate-300"><i class="fas fa-check-double text-5xl mb-4 block opacity-20"></i><p class="font-bold">Semua pendaftaran sudah diverifikasi</p></td></tr>
        @endforelse
        </tbody>
    </table></div>
</div>
{{-- History --}}
<div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm">
    <div class="p-6 border-b border-slate-50 bg-slate-50/50"><h3 class="font-bold text-slate-900 flex items-center gap-2"><i class="fas fa-history text-slate-400"></i> Riwayat Verifikasi</h3></div>
    <div class="overflow-x-auto"><table class="w-full text-sm">
        <thead><tr class="bg-slate-50/30 border-b border-slate-100"><th class="px-5 py-3 text-left font-bold text-slate-600 uppercase tracking-wider text-[10px]">Mahasiswa</th><th class="px-5 py-3 text-left font-bold text-slate-600 uppercase tracking-wider text-[10px]">Program Studi</th><th class="px-5 py-3 text-left font-bold text-slate-600 uppercase tracking-wider text-[10px]">Tanggal</th><th class="px-5 py-3 text-center font-bold text-slate-600 uppercase tracking-wider text-[10px]">Status</th></tr></thead>
        <tbody class="divide-y divide-slate-50">
        @foreach($historyList as $p)
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-5 py-4 font-bold text-slate-700 text-sm">{{ $p->mahasiswa->name ?? '-' }}</td>
                <td class="px-5 py-4 text-slate-500 text-xs font-medium">{{ $p->prodi->nama_prodi ?? '-' }}</td>
                <td class="px-5 py-4 text-slate-400 text-[10px] font-bold">{{ $p->registered_at?->format('d M Y') ?? '-' }}</td>
                <td class="px-5 py-4 text-center">
                    <span class="px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider {{ $p->status === 'diterima' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-red-50 text-red-700 border border-red-100' }}">
                        {{ $p->status }}
                    </span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table></div>
</div>
@endsection
