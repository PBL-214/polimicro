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
        <a href="{{ route('dosen.courses.show', $m->id) }}" class="block bg-white rounded-[2rem] border border-slate-100 overflow-hidden card-hover group transition-all duration-300 hover:shadow-xl hover:border-cyan-200 cursor-pointer relative"> 
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 p-6 relative"> 
                <div class="flex items-center justify-between mb-2"> 
                    <span class="text-[10px] font-bold uppercase tracking-widest text-cyan-400">{{ $m->prodi->nama_prodi ?? '' }}</span> 
                    <i class="fas fa-chalkboard-teacher text-cyan-500 opacity-50 group-hover:opacity-100 transition"></i> 
                </div> 
                <h3 class="font-bold text-white text-lg group-hover:text-cyan-400 transition">{{ $m->nama_makul }}</h3> 
            </div> 
            <div class="p-6"> 
                <p class="text-slate-500 text-sm mb-6 line-clamp-2 leading-relaxed">{{ $m->deskripsi ?: 'Kuasai kompetensi mendalam melalui kurikulum terstruktur dan bimbingan ahli.' }}</p> 
                <div class="flex items-center justify-between text-center"> 
                    <div class="p-3 bg-gray-50 rounded-xl flex-1 border border-slate-100 group-hover:border-cyan-100 transition"><p class="font-bold text-sm text-slate-700">{{ $studentCount }}</p><p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-1">Mahasiswa Aktif</p></div> 
                </div> 
            </div> 
        </a> 
    @endforeach
</div> 
<div class="mt-8"> 
    {{ $myMatkul->links() }}
</div>
@endsection
