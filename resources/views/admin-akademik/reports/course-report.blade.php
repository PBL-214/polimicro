@extends('layouts.dashboard')

@section('title', 'Laporan Kelas - ' . $makul->nama_makul)

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-4 mb-2">
            <a href="{{ route('admin-akademik.reports') }}" class="text-slate-400 hover:text-cyan-600 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Detail Laporan Kelas</h1>
        </div>
        <p class="text-slate-500 dark:text-slate-400 ml-8">{{ $makul->nama_makul }} - {{ $makul->prodi->nama_prodi }}</p>
    </div>
    <a href="{{ route('admin-akademik.reports.export', $makul->id) }}" class="px-5 py-2.5 bg-cyan-600 hover:bg-cyan-700 text-white rounded-xl text-sm font-bold shadow-md shadow-cyan-600/20 transition flex items-center justify-center gap-2">
        <i class="fas fa-file-csv"></i> Ekspor CSV
    </a>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6">
        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-1">Rata-rata Kelas</p>
        <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $stats['avg'] }}</p>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6">
        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-1">Nilai Tertinggi</p>
        <p class="text-3xl font-bold text-emerald-500">{{ $stats['max'] }}</p>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6">
        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-1">Nilai Terendah</p>
        <p class="text-3xl font-bold text-red-500">{{ $stats['min'] }}</p>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6">
        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-1">Total Mahasiswa</p>
        <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $stats['total_students'] }}</p>
    </div>
</div>

<div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-700/50 border-b border-slate-200 dark:border-slate-700">
                    <th class="p-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">No</th>
                    <th class="p-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">NIM / Nama Mahasiswa</th>
                    <th class="p-4 font-semibold text-slate-700 dark:text-slate-300 text-sm text-center">Tugas Dikumpul</th>
                    <th class="p-4 font-semibold text-slate-700 dark:text-slate-300 text-sm text-center">Rata Tugas</th>
                    <th class="p-4 font-semibold text-slate-700 dark:text-slate-300 text-sm text-center">Kuis Selesai</th>
                    <th class="p-4 font-semibold text-slate-700 dark:text-slate-300 text-sm text-center">Rata Kuis</th>
                    <th class="p-4 font-bold text-cyan-600 dark:text-cyan-400 text-sm text-center">Rata Keseluruhan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                @forelse($reportData as $index => $row)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                        <td class="p-4 text-sm text-slate-500 dark:text-slate-400 font-medium">
                            {{ $index + 1 }}
                        </td>
                        <td class="p-4">
                            <p class="font-bold text-slate-800 dark:text-slate-200 text-sm">{{ $row['student']->name }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-mono">{{ $row['student']->nim }}</p>
                        </td>
                        <td class="p-4 text-sm text-slate-600 dark:text-slate-400 text-center font-bold">
                            {{ $row['tugas_submitted'] }} / {{ $row['tugas_total'] }}
                        </td>
                        <td class="p-4 text-sm text-slate-600 dark:text-slate-400 text-center">
                            {{ $row['avg_tugas'] }}
                        </td>
                        <td class="p-4 text-sm text-slate-600 dark:text-slate-400 text-center font-bold">
                            {{ $row['quiz_taken'] }}
                        </td>
                        <td class="p-4 text-sm text-slate-600 dark:text-slate-400 text-center">
                            {{ $row['avg_quiz'] }}
                        </td>
                        <td class="p-4 text-base font-bold text-cyan-600 dark:text-cyan-400 text-center">
                            {{ $row['avg_overall'] }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-500 dark:text-slate-400 text-sm">
                            <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-user-slash text-slate-400 text-2xl"></i>
                            </div>
                            Belum ada mahasiswa yang terdaftar di kelas ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
