@extends('layouts.dashboard', ['activePage' => 'courses'])
@section('title', 'Matkul Saya - Dosen - Polimicro')
@section('content')
<h1 class="text-2xl font-bold text-slate-900 mb-2">Mata Kuliah Saya</h1>
<p class="text-slate-500 mb-6">Daftar mata kuliah yang Anda ampu</p>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6"> 
    @foreach($myMatkul as $m) 
        @php 
            $materiCount = $m->materi->count(); 
            $tugasCount = $m->tugas->count(); 
            $studentCount = $m->prodi->pendaftaranDiterima->count(); 
        @endphp 
        <a href="{{ route('dosen.courses.show', $m->id) }}" class="block bg-white rounded-2xl border border-slate-100 overflow-hidden card-hover group transition-all duration-300 hover:shadow-xl hover:border-cyan-200 cursor-pointer"> 
            <div class="gradient-card p-5 transition-colors group-hover:bg-cyan-50">
                <h3 class="font-bold text-cyan-900 transition group-hover:text-cyan-700">{{ $m->nama_makul }}</h3>
                <p class="text-cyan-700 text-xs mt-1 transition">{{ $m->prodi->nama_prodi ?? '' }}</p>
            </div> 
            <div class="p-5"> 
                <p class="text-slate-500 text-sm mb-4 line-clamp-2">{{ $m->deskripsi }}</p> 
                <div class="flex items-center justify-between text-center"> 
                    <div class="p-2 bg-gray-50 rounded-lg flex-1"><p class="font-bold text-sm">{{ $studentCount }}</p><p class="text-[10px] text-slate-400">Mahasiswa Aktif</p></div> 
                </div> 
            </div> 
        </a> 
    @endforeach
</div> 
<div class="mt-8"> 
    {{ $myMatkul->links() }}
</div>
@endsection
