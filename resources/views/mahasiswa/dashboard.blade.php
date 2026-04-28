@extends('layouts.dashboard', ['activePage' => 'dashboard'])
@section('title', 'Dashboard Mahasiswa - Polimicro')
@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Selamat Datang, {{ explode(' ', $user->name)[0] }}! 👋</h1>
    <p class="text-gray-500 mt-1">Berikut ringkasan aktivitas pembelajaran Anda</p>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-2xl p-5 border border-gray-100 card-hover">
        <div class="flex items-center justify-between mb-3"><div class="w-10 h-10 rounded-xl bg-cyan-100 flex items-center justify-center shadow-sm"><i class="fas fa-book-open text-cyan-600"></i></div><span class="text-xs text-cyan-600 font-medium"><i class="fas fa-arrow-up mr-1"></i>Aktif</span></div>
        <p class="text-2xl font-bold text-gray-900">{{ $enrolled->count() }}</p><p class="text-xs text-gray-400 mt-1">Mata Kuliah</p>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 card-hover">
        <div class="flex items-center justify-between mb-3"><div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center shadow-sm"><i class="fas fa-tasks text-blue-600"></i></div></div>
        <p class="text-2xl font-bold text-gray-900">{{ $submissions->count() }}</p><p class="text-xs text-gray-400 mt-1">Tugas Dikumpul</p>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 card-hover">
        <div class="flex items-center justify-between mb-3"><div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center shadow-sm"><i class="fas fa-star text-amber-600"></i></div></div>
        <p class="text-2xl font-bold text-gray-900">{{ $avgGrade }}</p><p class="text-xs text-gray-400 mt-1">Rata-rata Nilai</p>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 card-hover">
        <div class="flex items-center justify-between mb-3"><div class="w-10 h-10 rounded-xl bg-cyan-100 flex items-center justify-center shadow-sm"><i class="fas fa-certificate text-cyan-600"></i></div></div>
        <p class="text-2xl font-bold text-gray-900">{{ $certs->count() }}</p><p class="text-xs text-gray-400 mt-1">Sertifikat</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6 mb-8">
    {{-- Achievement Badges --}}
    <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 p-8 relative overflow-hidden shadow-sm">
        <div class="absolute top-0 right-0 p-8 opacity-5"><i class="fas fa-medal text-8xl text-cyan-600"></i></div>
        <h2 class="text-xl font-bold text-gray-900 mb-2 font-serif">Lencana Keahlian</h2>
        <p class="text-sm text-gray-400 mb-6">Selesaikan program untuk membuka lencana eksklusif</p>
        <div class="grid grid-cols-3 sm:grid-cols-5 gap-6">
            @php
                $badges = [
                    ['icon' => '🤖', 'label' => 'AI Expert', 'hint' => 'Selesaikan Program Artificial Intelligence', 'status' => $certs->where('prodi_id', 1)->count() > 0 ? 'unlocked' : 'locked'],
                    ['icon' => '📊', 'label' => 'Data Master', 'hint' => 'Selesaikan Program Data Science', 'status' => $certs->where('prodi_id', 2)->count() > 0 ? 'unlocked' : 'locked'],
                    ['icon' => '🔒', 'label' => 'Cyber Guard', 'hint' => 'Selesaikan Program Cybersecurity', 'status' => $certs->where('prodi_id', 3)->count() > 0 ? 'unlocked' : 'locked'],
                    ['icon' => '🎨', 'label' => 'UI/UX Pro', 'hint' => 'Selesaikan Program UI/UX Design', 'status' => $certs->where('prodi_id', 5)->count() > 0 ? 'unlocked' : 'locked'],
                    ['icon' => '🚀', 'label' => 'Super Starter', 'hint' => 'Kumpulkan tugas pertama Anda', 'status' => $submissions->count() >= 1 ? 'unlocked' : 'locked'],
                ];
            @endphp
            @foreach($badges as $badge)
                <div class="badge-container text-center group/badge relative cursor-help">
                    <div class="badge-card relative w-16 h-16 mx-auto rounded-2xl flex items-center justify-center text-2xl shadow-lg transition-all duration-300 {{ $badge['status'] === 'unlocked' ? 'bg-white border-2 border-cyan-100 group-hover/badge:scale-110 group-hover/badge:rotate-3 group-hover/badge:shadow-cyan-600/20' : 'bg-gray-100 grayscale opacity-40' }}">
                        {{ $badge['icon'] }}
                        @if($badge['status'] === 'unlocked') <div class="badge-glow"></div> @endif
                    </div>
                    <p class="text-[10px] font-bold mt-2 uppercase tracking-wider {{ $badge['status'] === 'unlocked' ? 'text-cyan-600' : 'text-gray-300' }}">{{ $badge['label'] }}</p>
                    
                    {{-- Tooltip --}}
                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-32 p-2 bg-slate-900 text-white text-[10px] rounded-lg opacity-0 invisible group-hover/badge:opacity-100 group-hover/badge:visible transition-all duration-300 z-20 pointer-events-none">
                        <p class="font-bold mb-1">{{ $badge['status'] === 'unlocked' ? 'Unlocked! 🎉' : 'Locked 🔒' }}</p>
                        <p class="opacity-70">{{ $badge['hint'] }}</p>
                        <div class="absolute top-full left-1/2 -translate-x-1/2 border-8 border-transparent border-t-slate-900"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Overall Progress --}}
    <div class="bg-white rounded-3xl border border-gray-100 p-8 flex flex-col items-center justify-center text-center shadow-sm">
        <div class="relative w-32 h-32 mb-4">
            <svg class="w-full h-full" viewBox="0 0 36 36">
                <path class="text-gray-100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" />
                <path class="text-cyan-500" stroke-dasharray="{{ $overallProgress }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-2xl font-bold text-gray-900">{{ $overallProgress }}%</span>
                <span class="text-[10px] text-gray-400 font-bold uppercase">Total</span>
            </div>
        </div>
        <h3 class="font-bold text-gray-900">Penyelesaian Program</h3>
        <p class="text-xs text-gray-400 mt-1">
            @if($overallProgress >= 100)
                Selamat! Anda telah menyelesaikan semua tugas.
            @elseif($overallProgress >= 50)
                Hampir mencapai target bulan ini!
            @else
                Terus semangat belajarnya!
            @endif
        </p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- Enrolled Courses - Visual Roadmap --}}
    <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 p-8 shadow-sm">
        <div class="flex items-center justify-between mb-8">
            <div><h2 class="text-xl font-bold text-gray-900 font-serif">Alur Belajar Saya</h2><p class="text-sm text-gray-400">Ikuti urutan materi untuk hasil maksimal</p></div>
            <a href="{{ route('mahasiswa.courses') }}" class="px-4 py-2 bg-slate-50 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-100 transition border border-slate-200">Lihat Katalog</a>
        </div>
        <div class="relative space-y-8 pl-4">
            <div class="roadmap-connector"></div>
            @forelse($enrolled->take(4) as $m)
                <div class="roadmap-dot flex items-center gap-6 group">
                    <div class="w-12 h-12 rounded-2xl bg-cyan-600 flex items-center justify-center text-white shadow-lg shadow-cyan-600/30 group-hover:scale-110 transition duration-300 flex-shrink-0 z-10"><i class="fas fa-book"></i></div>
                    <a href="{{ route('mahasiswa.materials', ['matkul' => $m->id]) }}" class="flex-1 p-5 rounded-2xl bg-slate-50 border border-transparent hover:border-cyan-200 hover:bg-white transition-all duration-300 group-hover:shadow-xl group-hover:shadow-black/5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-bold text-gray-900 group-hover:text-cyan-600 transition">{{ $m->nama_makul }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $m->prodi->nama_prodi ?? '' }} • {{ $m->dosen->name ?? '' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-bold text-cyan-600 bg-cyan-50 px-2 py-1 rounded-lg border border-cyan-100">{{ $m->progress }}% Selesai</span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <x-empty-state 
                    icon="fas fa-route" 
                    title="Mulai Perjalanan Anda" 
                    description="Anda belum mengambil mata kuliah apapun. Jelajahi katalog program kami."
                    actionText="Jelajahi Program"
                    :actionUrl="route('programs')"
                />
            @endforelse
        </div>
    </div>

    {{-- Upcoming Deadlines --}}
    <div class="bg-white rounded-3xl border border-gray-100 p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6 font-serif"><i class="fas fa-clock text-amber-500 mr-2"></i>Deadline</h2>
        <div class="space-y-4">
            @forelse($upcoming->take(5) as $t)
                <div class="p-4 rounded-2xl bg-white border border-gray-100 hover:border-amber-200 hover:shadow-lg hover:shadow-amber-500/5 transition duration-300">
                    <p class="font-bold text-sm text-gray-800">{{ $t->nama_tugas }}</p>
                    <p class="text-[11px] text-gray-400 mt-1 uppercase tracking-wider font-semibold">{{ $t->matkul_nama }}</p>
                    <div class="flex items-center justify-between mt-3">
                        <span class="text-[10px] px-2 py-1 bg-amber-50 text-amber-600 rounded-lg font-bold"><i class="fas fa-calendar-alt mr-1"></i>{{ $t->tanggal_akhir_deadline?->translatedFormat('d M') ?? '-' }}</span>
                        <button class="text-xs font-bold text-gray-400 hover:text-amber-600 transition">Kerjakan <i class="fas fa-arrow-right ml-1"></i></button>
                    </div>
                </div>
            @empty
                <x-empty-state 
                    icon="fas fa-calendar-check" 
                    title="Semua Beres!" 
                    description="Tidak ada tugas mendatang untuk saat ini."
                    class="py-10!"
                />
            @endforelse
        </div>
    </div>
</div>
@endsection
