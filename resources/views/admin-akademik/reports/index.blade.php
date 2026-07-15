@extends('layouts.dashboard')

@section('title', 'Laporan & Rekap Nilai - Admin Akademik')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">Laporan & Rekap Nilai</h1>
    <p class="text-slate-500 dark:text-slate-400">Unduh laporan performa akademik mahasiswa per program studi.</p>
</div>

<div class="space-y-8">
    @forelse($programs as $prodi)
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm p-6">
            <div class="flex items-center gap-4 mb-6 pb-4 border-b border-slate-100 dark:border-slate-700">
                <div class="w-12 h-12 rounded-2xl bg-cyan-50 dark:bg-cyan-900/30 text-cyan-600 dark:text-cyan-400 flex items-center justify-center text-xl">
                    <i class="fas fa-university"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800 dark:text-white">{{ $prodi->nama_prodi }}</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $prodi->makul->count() }} Mata Kuliah | {{ $prodi->pendaftaranDiterima->count() }} Mahasiswa</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                @forelse($prodi->makul as $makul)
                    <div class="p-5 border border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-700/30 rounded-2xl hover:border-cyan-200 dark:hover:border-cyan-800 transition">
                        <h4 class="font-bold text-slate-800 dark:text-white text-base mb-1">{{ $makul->nama_makul }}</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mb-4"><i class="fas fa-user-tie mr-1"></i> {{ $makul->dosen->name ?? 'Belum ada dosen' }}</p>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('admin-akademik.reports.course', $makul->id) }}" class="flex-1 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition text-center">
                                <i class="fas fa-chart-bar mr-1"></i> Detail
                            </a>
                            <a href="{{ route('admin-akademik.reports.export', $makul->id) }}" class="flex-1 py-2 bg-cyan-600 text-white rounded-xl text-xs font-bold hover:bg-cyan-700 transition shadow-md shadow-cyan-600/20 text-center">
                                <i class="fas fa-file-csv mr-1"></i> Ekspor
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-4 text-center text-slate-400 text-sm italic">
                        Belum ada mata kuliah untuk program studi ini.
                    </div>
                @endforelse
            </div>
        </div>
    @empty
        <div class="col-span-full py-12 text-center text-slate-500 dark:text-slate-400">
            <i class="fas fa-box-open text-4xl mb-3 text-slate-300 dark:text-slate-600"></i>
            <p>Belum ada program studi yang aktif.</p>
        </div>
    @endforelse
</div>
@endsection
