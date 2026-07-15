@extends('layouts.dashboard')

@section('title', 'Kehadiran - ' . $course->nama_makul)

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-4 mb-2">
            <a href="{{ route('mahasiswa.courses.show', $course->id) }}" class="text-slate-400 hover:text-cyan-600 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Kehadiran Saya</h1>
        </div>
        <p class="text-slate-500 dark:text-slate-400 ml-8">{{ $course->nama_makul }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6 flex flex-col items-center justify-center">
        <div class="w-12 h-12 rounded-full bg-emerald-50 dark:bg-emerald-900/30 text-emerald-500 dark:text-emerald-400 flex items-center justify-center text-xl mb-3">
            <i class="fas fa-check"></i>
        </div>
        <p class="text-3xl font-bold text-slate-800 dark:text-white mb-1">{{ $stats['hadir'] }}</p>
        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Hadir</p>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6 flex flex-col items-center justify-center">
        <div class="w-12 h-12 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-500 dark:text-blue-400 flex items-center justify-center text-xl mb-3">
            <i class="fas fa-envelope-open-text"></i>
        </div>
        <p class="text-3xl font-bold text-slate-800 dark:text-white mb-1">{{ $stats['izin'] }}</p>
        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Izin</p>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6 flex flex-col items-center justify-center">
        <div class="w-12 h-12 rounded-full bg-amber-50 dark:bg-amber-900/30 text-amber-500 dark:text-amber-400 flex items-center justify-center text-xl mb-3">
            <i class="fas fa-notes-medical"></i>
        </div>
        <p class="text-3xl font-bold text-slate-800 dark:text-white mb-1">{{ $stats['sakit'] }}</p>
        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Sakit</p>
    </div>
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6 flex flex-col items-center justify-center">
        <div class="w-12 h-12 rounded-full bg-red-50 dark:bg-red-900/30 text-red-500 dark:text-red-400 flex items-center justify-center text-xl mb-3">
            <i class="fas fa-times"></i>
        </div>
        <p class="text-3xl font-bold text-slate-800 dark:text-white mb-1">{{ $stats['alpha'] }}</p>
        <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Alpha</p>
    </div>
</div>

<div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
        <h2 class="text-lg font-bold text-slate-800 dark:text-white">Riwayat Kehadiran</h2>
        <div class="flex items-center gap-3">
            <div class="text-right">
                <p class="text-xs text-slate-500 dark:text-slate-400">Total Pertemuan</p>
                <p class="font-bold text-slate-800 dark:text-white text-lg">{{ $attendances->count() }}</p>
            </div>
            <div class="h-10 w-px bg-slate-200 dark:bg-slate-700 hidden sm:block"></div>
            <div class="text-left hidden sm:block">
                <p class="text-xs text-slate-500 dark:text-slate-400">Persentase Hadir</p>
                @php
                    $total = $attendances->count();
                    $percentage = $total > 0 ? round(($stats['hadir'] / $total) * 100) : 0;
                    $color = $percentage >= 75 ? 'emerald' : ($percentage >= 50 ? 'amber' : 'red');
                @endphp
                <p class="font-bold text-{{ $color }}-500 text-lg">{{ $percentage }}%</p>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-700/50 border-b border-slate-200 dark:border-slate-700">
                    <th class="p-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">Pertemuan Ke-</th>
                    <th class="p-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">Tanggal</th>
                    <th class="p-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">Materi / Catatan</th>
                    <th class="p-4 font-semibold text-slate-700 dark:text-slate-300 text-sm text-center">Status Anda</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                @forelse($attendances as $attendance)
                    @php
                        $myRecord = $attendance->records->firstWhere('mahasiswa_id', Auth::id());
                        $status = $myRecord ? $myRecord->status : 'Belum Ada';
                    @endphp
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                        <td class="p-4 text-sm font-bold text-slate-800 dark:text-white">
                            Pertemuan {{ $attendance->pertemuan_ke }}
                        </td>
                        <td class="p-4 text-sm text-slate-600 dark:text-slate-400">
                            {{ $attendance->tanggal->translatedFormat('d F Y') }}
                        </td>
                        <td class="p-4 text-sm text-slate-600 dark:text-slate-400">
                            {{ $attendance->catatan ?? '-' }}
                        </td>
                        <td class="p-4 text-center">
                            @if($status === 'hadir')
                                <span class="px-3 py-1 bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-800 rounded-lg text-xs font-bold inline-flex items-center gap-1.5"><i class="fas fa-check"></i> Hadir</span>
                            @elseif($status === 'izin')
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-100 dark:border-blue-800 rounded-lg text-xs font-bold inline-flex items-center gap-1.5"><i class="fas fa-envelope-open-text"></i> Izin</span>
                            @elseif($status === 'sakit')
                                <span class="px-3 py-1 bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400 border border-amber-100 dark:border-amber-800 rounded-lg text-xs font-bold inline-flex items-center gap-1.5"><i class="fas fa-notes-medical"></i> Sakit</span>
                            @elseif($status === 'alpha')
                                <span class="px-3 py-1 bg-red-50 text-red-600 dark:bg-red-900/30 dark:text-red-400 border border-red-100 dark:border-red-800 rounded-lg text-xs font-bold inline-flex items-center gap-1.5"><i class="fas fa-times"></i> Alpha</span>
                            @else
                                <span class="px-3 py-1 bg-slate-100 text-slate-500 dark:bg-slate-700 dark:text-slate-400 border border-slate-200 dark:border-slate-600 rounded-lg text-xs font-bold">Menunggu Catatan</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-500 dark:text-slate-400 text-sm">
                            <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-calendar-times text-slate-400 text-2xl"></i>
                            </div>
                            Belum ada catatan kehadiran untuk kelas ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
