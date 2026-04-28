@extends('layouts.dashboard', ['activePage' => 'courses'])
@section('title', 'Mata Kuliah Saya - Polimicro')
@section('content')
<h1 class="text-2xl font-bold text-gray-900 mb-2">Mata Kuliah Saya</h1>
<p class="text-gray-500 mb-6">Daftar mata kuliah yang Anda ikuti</p>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($enrolled as $m)
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden card-hover">
            <div class="gradient-card p-5"><h3 class="font-bold text-cyan-900">{{ $m->nama_makul }}</h3><p class="text-cyan-700 text-xs mt-1">{{ $m->prodi->nama_prodi ?? '' }}</p></div>
            <div class="p-5">
                <p class="text-gray-500 text-sm mb-4">{{ $m->deskripsi }}</p>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-7 h-7 rounded-full bg-cyan-100 flex items-center justify-center text-xs font-bold text-cyan-700">{{ $m->dosen ? $m->dosen->getInitials() : '?' }}</div>
                    <span class="text-xs text-gray-500">{{ $m->dosen->name ?? '-' }}</span>
                </div>
                <div class="flex gap-4 text-xs text-gray-400 mb-4">
                    <span><i class="fas fa-file-alt mr-1"></i>{{ $m->materi->count() }} Materi</span>
                    <span><i class="fas fa-tasks mr-1"></i>{{ $m->tugas->count() }} Tugas</span>
                    <span><i class="fas fa-credit-card mr-1"></i>{{ $m->sks }} SKS</span>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('mahasiswa.materials', ['matkul' => $m->id]) }}" class="flex-1 text-center py-2 text-sm btn-primary text-white rounded-xl font-medium">Materi</a>
                    <a href="{{ route('mahasiswa.assignments', ['matkul' => $m->id]) }}" class="flex-1 text-center py-2 text-sm bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">Tugas</a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-16"><i class="fas fa-book-open text-4xl text-gray-300 mb-4"></i><p class="text-gray-400">Belum ada mata kuliah. <a href="{{ route('programs') }}" class="text-cyan-600 font-medium">Daftar program</a> terlebih dahulu.</p></div>
    @endforelse
</div>
@endsection
