@extends('layouts.dashboard', ['activePage' => 'verification'])
@section('title', 'Verifikasi Mahasiswa - Admin PIC - Polimicro')
@section('content')
<h1 class="text-2xl font-bold text-gray-900 mb-2">Verifikasi Mahasiswa</h1>
<p class="text-gray-500 mb-6">Verifikasi pendaftaran mahasiswa baru</p>
{{-- Pending --}}
<div class="bg-white rounded-2xl border border-gray-100 mb-6 overflow-hidden">
    <div class="p-5 border-b border-gray-50"><h3 class="font-bold text-gray-900"><i class="fas fa-clock text-amber-500 mr-2"></i>Menunggu Verifikasi ({{ $pendingList->count() }})</h3></div>
    <div class="overflow-x-auto"><table class="w-full text-sm">
        <thead><tr class="bg-gray-50" style="background:#faf8f5"><th class="px-5 py-3 text-left font-semibold text-gray-600">Mahasiswa</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Program Studi</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Tanggal Daftar</th><th class="px-5 py-3 text-center font-semibold text-gray-600">Aksi</th></tr></thead>
        <tbody class="divide-y divide-gray-50">
        @forelse($pendingList as $p)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-4"><div class="flex items-center gap-3"><div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center text-xs font-bold text-amber-700">{{ $p->mahasiswa ? $p->mahasiswa->getInitials() : '?' }}</div><div><p class="font-medium">{{ $p->mahasiswa->name ?? '-' }}</p><p class="text-xs text-gray-400">{{ $p->mahasiswa->email ?? '' }}</p></div></div></td>
                <td class="px-5 py-4 text-gray-500">{{ $p->prodi->nama_prodi ?? '-' }}</td>
                <td class="px-5 py-4 text-gray-400 text-xs">{{ $p->registered_at?->format('d/m/Y') ?? '-' }}</td>
                <td class="px-5 py-4 text-center"><div class="flex gap-2 justify-center">
                    <form method="POST" action="{{ route('admin-pic.verification.verify', $p) }}">@csrf @method('PUT')<input type="hidden" name="status" value="diterima"><button class="px-4 py-2 bg-cyan-50 text-cyan-600 rounded-lg text-xs hover:bg-cyan-100 font-medium"><i class="fas fa-check mr-1"></i>Terima</button></form>
                    <form method="POST" action="{{ route('admin-pic.verification.verify', $p) }}">@csrf @method('PUT')<input type="hidden" name="status" value="ditolak"><button class="px-4 py-2 bg-red-50 text-red-600 rounded-lg text-xs hover:bg-red-100 font-medium"><i class="fas fa-times mr-1"></i>Tolak</button></form>
                </div></td>
            </tr>
        @empty
            <tr><td colspan="4" class="px-5 py-12 text-center text-gray-400"><i class="fas fa-check-circle text-3xl text-cyan-300 mb-2"></i><p>Semua pendaftaran sudah diverifikasi</p></td></tr>
        @endforelse
        </tbody>
    </table></div>
</div>
{{-- History --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="p-5 border-b border-gray-50"><h3 class="font-bold text-gray-900"><i class="fas fa-history text-gray-400 mr-2"></i>Riwayat Verifikasi</h3></div>
    <div class="overflow-x-auto"><table class="w-full text-sm">
        <thead><tr class="bg-gray-50" style="background:#faf8f5"><th class="px-5 py-3 text-left font-semibold text-gray-600">Mahasiswa</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Program Studi</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Tanggal</th><th class="px-5 py-3 text-center font-semibold text-gray-600">Status</th></tr></thead>
        <tbody class="divide-y divide-gray-50">
        @foreach($historyList as $p)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-4 font-medium">{{ $p->mahasiswa->name ?? '-' }}</td>
                <td class="px-5 py-4 text-gray-500">{{ $p->prodi->nama_prodi ?? '-' }}</td>
                <td class="px-5 py-4 text-gray-400 text-xs">{{ $p->registered_at?->format('d/m/Y') ?? '-' }}</td>
                <td class="px-5 py-4 text-center"><span class="px-3 py-1 rounded-full text-xs font-semibold {{ $p->status === 'diterima' ? 'bg-cyan-100 text-cyan-700' : 'bg-red-100 text-red-700' }}">{{ ucfirst($p->status) }}</span></td>
            </tr>
        @endforeach
        </tbody>
    </table></div>
</div>
@endsection
