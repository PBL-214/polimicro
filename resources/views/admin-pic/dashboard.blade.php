@extends('layouts.dashboard', ['activePage' => 'dashboard'])
@section('title', 'Dashboard Admin PIC - Polimicro')
@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 font-serif">Pusat Informasi & Kontrol</h1>
        <p class="text-gray-500 mt-1">Pantau dan verifikasi aktivitas pendaftaran mahasiswa</p>
    </div>
    <a href="{{ route('admin-pic.verification') }}" class="px-6 py-3 bg-cyan-600 text-white rounded-xl font-bold text-sm hover:bg-cyan-700 transition shadow-lg shadow-cyan-600/20"><i class="fas fa-user-check mr-2"></i>Verifikasi</a>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-3xl p-6 border border-gray-100 card-hover">
        <div class="w-12 h-12 rounded-2xl bg-cyan-50 flex items-center justify-center text-cyan-600 mb-4 shadow-sm border border-cyan-100"><i class="fas fa-users"></i></div>
        <p class="text-3xl font-bold text-gray-900">{{ $totalMhs }}</p>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mt-1">Total Mahasiswa</p>
    </div>
    <div class="bg-white rounded-3xl p-6 border border-gray-100 card-hover">
        <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 mb-4 shadow-sm border border-amber-100"><i class="fas fa-clock"></i></div>
        <p class="text-3xl font-bold text-gray-900">{{ $pending }}</p>
        <p class="text-xs text-amber-600 font-semibold uppercase tracking-wider mt-1">Perlu Verifikasi</p>
    </div>
    <div class="bg-white rounded-3xl p-6 border border-gray-100 card-hover">
        <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 mb-4 shadow-sm border border-blue-100"><i class="fas fa-book"></i></div>
        <p class="text-3xl font-bold text-gray-900">{{ $totalMatkul }}</p>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mt-1">Mata Kuliah</p>
    </div>
    <div class="bg-white rounded-3xl p-6 border border-gray-100 card-hover">
        <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600 mb-4 shadow-sm border border-purple-100"><i class="fas fa-university"></i></div>
        <p class="text-3xl font-bold text-gray-900">{{ $activeProdi }}</p>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mt-1">Prodi Aktif</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-8">
    {{-- Registration Chart --}}
    <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6 font-serif">Statistik Pendaftaran</h2>
        <div class="h-64">
            <canvas id="chart1"></canvas>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="bg-white rounded-3xl border border-gray-100 p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6 font-serif">Aktivitas Terbaru</h2>
        <div class="space-y-4">
            @forelse($recentPendaftaran as $p)
                <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-transparent hover:bg-white hover:border-cyan-100 transition duration-300">
                    <div class="w-10 h-10 rounded-full bg-cyan-100 flex items-center justify-center text-cyan-700 font-bold text-xs shadow-sm">{{ $p->mahasiswa ? $p->mahasiswa->getInitials() : '?' }}</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-800 truncate">{{ $p->mahasiswa->name ?? '-' }}</p>
                        <p class="text-[11px] text-slate-400 mt-0.5 truncate uppercase tracking-wider font-semibold">{{ $p->prodi->nama_prodi ?? '-' }}</p>
                    </div>
                    <span class="px-2 py-1 rounded-lg text-[9px] font-bold uppercase {{ $p->status === 'diterima' ? 'bg-emerald-50 text-emerald-700' : ($p->status === 'pending' ? 'bg-amber-50 text-amber-700' : 'bg-red-50 text-red-700') }}">{{ $p->status }}</span>
                </div>
            @empty
                <p class="text-gray-400 text-sm text-center py-8">Belum ada pendaftaran</p>
            @endforelse
        </div>
    </div>
</div>

@push('styles')<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>@endpush
@push('scripts')
<script>
const ctx = document.getElementById('chart1');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($prodiList->pluck('nama_prodi')),
        datasets: [
            { label: 'Diterima', data: @json($prodiList->map(fn($p) => $p->pendaftaran()->where('status','diterima')->count())), backgroundColor: '#0891B2', borderRadius: 12 },
            { label: 'Pending', data: @json($prodiList->map(fn($p) => $p->pendaftaran()->where('status','pending')->count())), backgroundColor: '#f59e0b', borderRadius: 12 },
            { label: 'Ditolak', data: @json($prodiList->map(fn($p) => $p->pendaftaran()->where('status','ditolak')->count())), backgroundColor: '#ef4444', borderRadius: 12 }
        ]
    },
    options: { 
        maintainAspectRatio: false,
        responsive: true, 
        plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { family: 'Plus Jakarta Sans', size: 11, weight: '600' } } } }, 
        scales: { 
            y: { grid: { display: false }, beginAtZero: true, ticks: { stepSize: 1, font: { family: 'Plus Jakarta Sans', size: 10 } } },
            x: { grid: { display: false }, ticks: { font: { family: 'Plus Jakarta Sans', size: 10, weight: '600' } } }
        } 
    }
});
</script>
@endpush
@endsection
