@extends('layouts.dashboard', ['activePage' => 'courses'])
@section('title', 'Mata Kuliah Saya - Polimicro')
@section('content')
<h1 class="text-2xl font-bold text-slate-900 mb-2">Mata Kuliah Saya</h1>
<p class="text-slate-500 mb-6">Daftar mata kuliah yang Anda ikuti</p>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6"> 
    @forelse($enrolled as $m) 
        <a href="{{ route('mahasiswa.courses.show', $m->id) }}" class="block bg-white rounded-[2rem] border border-slate-100 overflow-hidden card-hover group transition-all duration-300 hover:shadow-xl hover:border-cyan-200 cursor-pointer relative"> 
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 p-6 relative"> 
                <div class="flex items-center justify-between mb-2"> 
                    <span class="text-[10px] font-bold uppercase tracking-widest text-cyan-400">{{ $m->prodi->nama_prodi ?? '' }}</span> 
                    <i class="fas fa-bookmark text-cyan-500 opacity-50 group-hover:opacity-100 transition"></i> 
                </div> 
                <h3 class="font-bold text-white text-lg group-hover:text-cyan-400 transition">{{ $m->nama_makul }}</h3> 
            </div> 
            <div class="p-6"> 
                <p class="text-slate-500 text-sm mb-6 line-clamp-2 leading-relaxed">{{ $m->deskripsi ?: 'Kuasai kompetensi mendalam melalui kurikulum terstruktur dan bimbingan ahli.' }}</p> 
                {{-- Progress Bar --}} 
                <div class="mb-6"> 
                    <div class="flex items-center justify-between mb-2"> 
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Progres Belajar</span> 
                        <span class="text-xs font-bold text-cyan-600">{{ $m->progress }}%</span> 
                    </div> 
                    <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden"> 
                        <div class="h-full bg-cyan-600 rounded-full transition-all duration-1000" style="width: {{ $m->progress }}%"></div> 
                    </div> 
                </div> 
            </div> 
        </a> 
    @empty 
        <div class="col-span-full py-20 text-center"> 
            <div class="w-20 h-20 bg-slate-100 rounded-3xl flex items-center justify-center mx-auto mb-6"><i class="fas fa-book-open text-3xl text-slate-300"></i></div> 
            <h3 class="font-bold text-slate-900 mb-2">Belum Ada Mata Kuliah</h3> 
            <p class="text-slate-500 text-sm mb-8">Daftar ke program studi untuk memulai perjalanan belajar Anda.</p> 
            <a href="{{ route('programs') }}" class="btn-primary">Cari Program</a> 
        </div> 
    @endforelse
</div>
@endsection
