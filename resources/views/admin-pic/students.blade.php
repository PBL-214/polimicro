@extends('layouts.dashboard', ['activePage' => 'students'])
@section('title', 'Data Pelajar - Admin PIC - Polimicro')
@section('content')
<h1 class="text-2xl font-bold text-gray-900 mb-2">Data Pelajar</h1>
<p class="text-gray-500 mb-6">Kelola data mahasiswa per program studi</p>
<div class="flex flex-wrap gap-4 mb-6">
    <select class="px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm" onchange="let p=this.value;let s=document.getElementById('search-box').value;window.location='{{ route('admin-pic.students') }}?prodi='+p+'&search='+s">
        <option value="all">Semua Prodi</option>
        @foreach($prodiList as $p)<option value="{{ $p->id }}" {{ $prodiFilter == $p->id ? 'selected' : '' }}>{{ $p->nama_prodi }}</option>@endforeach
    </select>
    <form class="relative flex-1 min-w-[200px]"><i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
        <input type="text" name="search" id="search-box" placeholder="Cari mahasiswa..." value="{{ $search }}" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 bg-white text-sm">
        @if($prodiFilter)<input type="hidden" name="prodi" value="{{ $prodiFilter }}">@endif
    </form>
</div>
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="p-5 border-b border-gray-50 flex justify-between"><span class="font-bold text-gray-900">Daftar Mahasiswa</span><span class="text-sm text-gray-400">{{ $students->count() }} data</span></div>
    <div class="overflow-x-auto"><table class="w-full text-sm">
        <thead><tr class="bg-gray-50" style="background:#faf8f5"><th class="px-5 py-3 text-left font-semibold text-gray-600">Nama</th><th class="px-5 py-3 text-left font-semibold text-gray-600">NIM</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Email</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Telepon</th><th class="px-5 py-3 text-center font-semibold text-gray-600">Status</th></tr></thead>
        <tbody class="divide-y divide-gray-50">
        @forelse($students as $s)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-4"><div class="flex items-center gap-3"><div class="w-8 h-8 rounded-full bg-cyan-100 flex items-center justify-center text-xs font-bold text-cyan-700">{{ $s->getInitials() }}</div><span class="font-medium">{{ $s->name }}</span></div></td>
                <td class="px-5 py-4 text-gray-500 font-mono text-xs">{{ $s->nim ?? '-' }}</td>
                <td class="px-5 py-4 text-gray-500 text-xs">{{ $s->email }}</td>
                <td class="px-5 py-4 text-gray-400 text-xs">{{ $s->phone ?? '-' }}</td>
                <td class="px-5 py-4 text-center"><span class="px-3 py-1 rounded-full text-xs font-semibold {{ $s->status === 'aktif' ? 'bg-cyan-100 text-cyan-700' : 'bg-yellow-100 text-yellow-700' }}">{{ ucfirst($s->status) }}</span></td>
            </tr>
        @empty
            <tr><td colspan="5" class="px-5 py-12 text-center text-gray-400">Tidak ada data</td></tr>
        @endforelse
        </tbody>
    </table></div>
</div>
@endsection
