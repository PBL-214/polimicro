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
        <div class="flex items-center justify-between mb-3"><div class="w-10 h-10 rounded-xl bg-cyan-100 flex items-center justify-center"><i class="fas fa-book-open text-cyan-600"></i></div><span class="text-xs text-cyan-600 font-medium"><i class="fas fa-arrow-up mr-1"></i>Aktif</span></div>
        <p class="text-2xl font-bold text-gray-900">{{ $enrolled->count() }}</p><p class="text-xs text-gray-400 mt-1">Mata Kuliah</p>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 card-hover">
        <div class="flex items-center justify-between mb-3"><div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center"><i class="fas fa-tasks text-blue-600"></i></div></div>
        <p class="text-2xl font-bold text-gray-900">{{ $submissions->count() }}</p><p class="text-xs text-gray-400 mt-1">Tugas Dikumpul</p>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 card-hover">
        <div class="flex items-center justify-between mb-3"><div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center"><i class="fas fa-star text-amber-600"></i></div></div>
        <p class="text-2xl font-bold text-gray-900">{{ $avgGrade }}</p><p class="text-xs text-gray-400 mt-1">Rata-rata Nilai</p>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 card-hover">
        <div class="flex items-center justify-between mb-3"><div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center"><i class="fas fa-certificate text-purple-600"></i></div></div>
        <p class="text-2xl font-bold text-gray-900">{{ $certs->count() }}</p><p class="text-xs text-gray-400 mt-1">Sertifikat</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6 mb-8">
    {{-- Achievement Badges --}}
    <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 p-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-8 opacity-5"><i class="fas fa-medal text-8xl text-cyan-600"></i></div>
        <h2 class="text-xl font-bold text-gray-900 mb-2 font-serif">Lencana Keahlian</h2>
        <p class="text-sm text-gray-400 mb-6">Selesaikan program untuk membuka lencana eksklusif</p>
        <div class="grid grid-cols-3 sm:grid-cols-5 gap-6">
            @php
                $badges = [
                    ['icon' => '🤖', 'label' => 'AI Expert', 'status' => $certs->where('prodi_id', 1)->count() > 0 ? 'unlocked' : 'locked'],
                    ['icon' => '📊', 'label' => 'Data Master', 'status' => 'locked'],
                    ['icon' => '🔒', 'label' => 'Cyber Guard', 'status' => 'locked'],
                    ['icon' => '🎨', 'label' => 'UI/UX Pro', 'status' => 'locked'],
                    ['icon' => '🚀', 'label' => 'Super Starter', 'status' => 'unlocked'],
                ];
            @endphp
            @foreach($badges as $badge)
                <div class="badge-container text-center">
                    <div class="badge-card relative w-16 h-16 mx-auto rounded-2xl flex items-center justify-center text-2xl shadow-lg {{ $badge['status'] === 'unlocked' ? 'bg-white border-2 border-cyan-100' : 'bg-gray-100 grayscale opacity-40' }}">
                        {{ $badge['icon'] }}
                        @if($badge['status'] === 'unlocked') <div class="badge-glow"></div> @endif
                    </div>
                    <p class="text-[10px] font-bold mt-2 uppercase tracking-wider {{ $badge['status'] === 'unlocked' ? 'text-cyan-600' : 'text-gray-300' }}">{{ $badge['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Overall Progress --}}
    <div class="bg-white rounded-3xl border border-gray-100 p-8 flex flex-col items-center justify-center text-center">
        <div class="relative w-32 h-32 mb-4">
            <svg class="w-full h-full" viewBox="0 0 36 36">
                <path class="text-gray-100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" />
                <path class="text-cyan-600" stroke-dasharray="75, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-2xl font-bold text-gray-900">75%</span>
                <span class="text-[10px] text-gray-400 font-bold uppercase">Total</span>
            </div>
        </div>
        <h3 class="font-bold text-gray-900">Penyelesaian Program</h3>
        <p class="text-xs text-gray-400 mt-1">Hampir mencapai target bulan ini!</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    {{-- Enrolled Courses - Visual Roadmap --}}
    <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 p-8">
        <div class="flex items-center justify-between mb-8">
            <div><h2 class="text-xl font-bold text-gray-900 font-serif">Alur Belajar Saya</h2><p class="text-sm text-gray-400">Ikuti urutan materi untuk hasil maksimal</p></div>
            <a href="{{ route('mahasiswa.courses') }}" class="px-4 py-2 bg-gray-50 text-gray-600 rounded-xl text-xs font-bold hover:bg-gray-100 transition">Lihat Katalog</a>
        </div>
        <div class="relative space-y-8 pl-4">
            <div class="roadmap-connector"></div>
            @forelse($enrolled->take(4) as $m)
                <div class="roadmap-dot flex items-center gap-6 group">
                    <div class="w-12 h-12 rounded-2xl gradient-primary flex items-center justify-center text-white shadow-lg shadow-cyan-500/30 group-hover:scale-110 transition duration-300 flex-shrink-0 z-10"><i class="fas fa-book"></i></div>
                    <a href="{{ route('mahasiswa.materials', ['matkul' => $m->id]) }}" class="flex-1 p-5 rounded-2xl bg-gray-50 border border-transparent hover:border-cyan-200 hover:bg-white transition-all duration-300 group-hover:shadow-xl group-hover:shadow-black/5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-bold text-gray-900 group-hover:text-cyan-600 transition">{{ $m->nama_makul }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $m->prodi->nama_prodi ?? '' }} • {{ $m->dosen->name ?? '' }}</p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-bold text-cyan-600 bg-cyan-50 px-2 py-1 rounded-lg">80% Selesai</span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="text-center py-12"><i class="fas fa-route text-4xl text-gray-200 mb-4 block"></i><p class="text-gray-400 text-sm">Belum ada mata kuliah yang diambil</p></div>
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
                <p class="text-gray-400 text-sm text-center py-4">Tidak ada tugas mendatang</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
