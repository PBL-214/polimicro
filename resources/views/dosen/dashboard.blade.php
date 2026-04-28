@extends('layouts.dashboard', ['activePage' => 'dashboard'])
@section('title', 'Dashboard Dosen - Polimicro')
@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 font-serif">Dashboard Dosen</h1>
        <p class="text-gray-500 mt-1">Kelola pembelajaran dan pantau progres mahasiswa Anda</p>
    </div>
    <div class="hidden sm:flex gap-2">
        <button class="px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl text-xs font-bold border border-emerald-100 hover:bg-emerald-100 transition"><i class="fas fa-plus mr-2"></i>Materi Baru</button>
        <button class="px-4 py-2 bg-gray-900 text-white rounded-xl text-xs font-bold hover:bg-black transition shadow-lg shadow-black/10"><i class="fas fa-clipboard-list mr-2"></i>Buka Penugasan</button>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-3xl p-6 border border-gray-100 card-hover">
        <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-4 shadow-sm border border-emerald-100"><i class="fas fa-book-open"></i></div>
        <p class="text-2xl font-bold text-gray-900">{{ $myMatkul->count() }}</p>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mt-1">Matkul Diampu</p>
    </div>
    <div class="bg-white rounded-3xl p-6 border border-gray-100 card-hover">
        <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 mb-4 shadow-sm border border-blue-100"><i class="fas fa-file-alt"></i></div>
        <p class="text-2xl font-bold text-gray-900">{{ $totalMateri }}</p>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mt-1">Total Materi</p>
    </div>
    <div class="bg-white rounded-3xl p-6 border border-gray-100 card-hover">
        <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 mb-4 shadow-sm border border-amber-100"><i class="fas fa-tasks"></i></div>
        <p class="text-2xl font-bold text-gray-900">{{ $totalTugas }}</p>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mt-1">Total Tugas</p>
    </div>
    <div class="bg-white rounded-3xl p-6 border border-gray-100 card-hover">
        <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600 mb-4 shadow-sm border border-purple-100"><i class="fas fa-users"></i></div>
        <p class="text-2xl font-bold text-gray-900">{{ $totalStudents }}</p>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mt-1">Total Mahasiswa</p>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-8">
    {{-- Active Courses --}}
    <div class="bg-white rounded-3xl border border-gray-100 p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900 font-serif">Mata Kuliah Saya</h2>
            <a href="{{ route('dosen.courses') }}" class="text-xs font-bold text-emerald-600 hover:underline">Kelola Semua</a>
        </div>
        <div class="space-y-4">
            @forelse($myMatkul as $m)
                <div class="group flex items-center gap-4 p-4 rounded-2xl bg-gray-50 border border-transparent hover:border-emerald-200 hover:bg-white transition-all duration-300">
                    <div class="w-12 h-12 rounded-2xl gradient-emerald flex items-center justify-center text-white shadow-lg shadow-emerald-500/20 group-hover:scale-110 transition duration-300"><i class="fas fa-book"></i></div>
                    <div class="flex-1">
                        <p class="font-bold text-gray-900">{{ $m->nama_makul }}</p>
                        <p class="text-xs text-gray-400">{{ $m->prodi->nama_prodi ?? 'Prodi' }} • {{ $m->sks }} SKS</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-300 group-hover:text-emerald-500 transition"></i>
                </div>
            @empty
                <div class="text-center py-8"><p class="text-gray-400 text-sm">Belum ada mata kuliah yang diampu</p></div>
            @endforelse
        </div>
    </div>

    {{-- Recent Submissions --}}
    <div class="bg-white rounded-3xl border border-gray-100 p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900 font-serif">Pengumpulan Terbaru</h2>
            <a href="{{ route('dosen.submissions') }}" class="text-xs font-bold text-emerald-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="space-y-4">
            @forelse($recentSubs as $s)
                <div class="flex items-center gap-4 p-4 rounded-2xl bg-white border border-gray-50 hover:shadow-xl hover:shadow-black/5 transition duration-300">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white font-bold text-xs shadow-md">{{ $s->mahasiswa ? $s->mahasiswa->getInitials() : '?' }}</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 truncate">{{ $s->mahasiswa->name ?? '-' }}</p>
                        <p class="text-[11px] text-gray-400 mt-0.5 truncate uppercase tracking-wider font-semibold">{{ $s->tugas->nama_tugas ?? '-' }}</p>
                    </div>
                    @if($s->nilai !== null)
                        <div class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-lg font-bold text-sm">{{ $s->nilai }}</div>
                    @else
                        <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-lg font-bold text-[10px] uppercase">Perlu Nilai</span>
                    @endif
                </div>
            @empty
                <div class="text-center py-12"><i class="fas fa-inbox text-4xl text-gray-200 mb-4 block"></i><p class="text-gray-400 text-sm">Belum ada pengumpulan tugas</p></div>
            @endforelse
        </div>
    </div>
</div>
@endsection
