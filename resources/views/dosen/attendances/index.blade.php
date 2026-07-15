@extends('layouts.dashboard')

@section('title', 'Kehadiran Mahasiswa - ' . $course->nama_makul)

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-4 mb-2">
            <a href="{{ route('dosen.courses.show', $course->id) }}" class="text-slate-400 hover:text-cyan-600 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Kehadiran Mahasiswa</h1>
        </div>
        <p class="text-slate-500 dark:text-slate-400 ml-8">{{ $course->nama_makul }}</p>
    </div>
    <a href="{{ route('dosen.courses.attendances.create', $course->id) }}" class="px-5 py-2.5 bg-cyan-600 hover:bg-cyan-700 text-white rounded-xl text-sm font-bold shadow-md shadow-cyan-600/20 transition flex items-center justify-center gap-2">
        <i class="fas fa-plus"></i> Catat Kehadiran Baru
    </a>
</div>

<div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-700/50 border-b border-slate-200 dark:border-slate-700">
                    <th class="p-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">Pertemuan Ke-</th>
                    <th class="p-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">Tanggal</th>
                    <th class="p-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">Statistik (Hadir/Total)</th>
                    <th class="p-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">Catatan</th>
                    <th class="p-4 font-semibold text-slate-700 dark:text-slate-300 text-sm text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                @forelse($attendances as $attendance)
                    @php
                        $hadir = $attendance->records->where('status', 'hadir')->count();
                        $total = $attendance->records->count();
                        $percentage = $total > 0 ? round(($hadir / $total) * 100) : 0;
                    @endphp
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                        <td class="p-4 text-sm font-bold text-slate-800 dark:text-white">
                            Pertemuan {{ $attendance->pertemuan_ke }}
                        </td>
                        <td class="p-4 text-sm text-slate-600 dark:text-slate-400">
                            {{ $attendance->tanggal->translatedFormat('d F Y') }}
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="flex-1 max-w-[120px] bg-slate-200 dark:bg-slate-700 rounded-full h-2 overflow-hidden">
                                    <div class="bg-emerald-500 h-full rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ $hadir }}/{{ $total }} ({{ $percentage }}%)</span>
                            </div>
                        </td>
                        <td class="p-4 text-sm text-slate-600 dark:text-slate-400 truncate max-w-[200px]" title="{{ $attendance->catatan }}">
                            {{ $attendance->catatan ?? '-' }}
                        </td>
                        <td class="p-4 text-right">
                            <button type="button" onclick="openDetailModal({{ $attendance->id }})" class="px-3 py-1.5 bg-cyan-50 text-cyan-600 dark:bg-cyan-900/30 dark:text-cyan-400 rounded-lg text-xs font-bold hover:bg-cyan-100 dark:hover:bg-cyan-900/50 transition border border-cyan-100 dark:border-cyan-800">
                                Detail / Edit
                            </button>
                            <div id="attendance-data-{{ $attendance->id }}" class="hidden">
                                {!! json_encode($attendance->records->map(function($record) {
                                    return ['id' => $record->mahasiswa_id, 'name' => $record->mahasiswa->name, 'status' => $record->status];
                                })) !!}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-500 dark:text-slate-400 text-sm">
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

{{-- Detail/Edit Modal --}}
<div id="detail-modal" class="fixed inset-0 z-50 hidden items-center justify-center shadow-2xl" style="background:rgba(15,23,42,0.6); backdrop-filter: blur(4px);">
    <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 max-w-2xl w-full mx-4 fade-in border border-slate-100 dark:border-slate-700 max-h-[90vh] flex flex-col">
        <div class="flex items-center justify-between mb-6 shrink-0">
            <h3 class="text-xl font-bold font-serif text-slate-800 dark:text-white" id="modal-title">Detail Kehadiran</h3>
            <button type="button" onclick="closeDetailModal()" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-400 hover:text-slate-600 dark:hover:text-white transition"><i class="fas fa-times text-sm"></i></button>
        </div>
        
        <form id="edit-form" method="POST" action="" class="flex-1 overflow-y-auto custom-scrollbar space-y-4 pr-2">
            @csrf @method('PUT')
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/50 border-b border-slate-200 dark:border-slate-700">
                        <th class="py-3 px-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">Mahasiswa</th>
                        <th class="py-3 px-4 font-semibold text-slate-700 dark:text-slate-300 text-sm text-center">Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody id="student-list" class="divide-y divide-slate-100 dark:divide-slate-700">
                    <!-- Populated by JS -->
                </tbody>
            </table>
            
            <div class="pt-6 shrink-0 flex gap-3">
                <button type="button" onclick="closeDetailModal()" class="flex-1 py-3 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl font-semibold hover:bg-slate-200 dark:hover:bg-slate-600 transition">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-cyan-600 text-white rounded-xl font-semibold hover:bg-cyan-700 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openDetailModal(attendanceId) {
    const records = JSON.parse(document.getElementById('attendance-data-' + attendanceId).innerHTML);
    const tbody = document.getElementById('student-list');
    tbody.innerHTML = '';
    
    document.getElementById('edit-form').action = `{{ url('dosen/courses/' . $course->id . '/attendances') }}/${attendanceId}`;
    document.getElementById('modal-title').innerText = `Edit Kehadiran`;

    records.forEach(record => {
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-slate-50 dark:hover:bg-slate-700/50 transition';
        
        tr.innerHTML = `
            <td class="py-3 px-4 text-sm font-semibold text-slate-800 dark:text-slate-200">
                ${record.name}
            </td>
            <td class="py-3 px-4">
                <div class="flex justify-center gap-2">
                    <label class="cursor-pointer">
                        <input type="radio" name="status[${record.id}]" value="hadir" class="peer sr-only" ${record.status === 'hadir' ? 'checked' : ''}>
                        <div class="w-8 h-8 flex items-center justify-center rounded-lg border-2 border-slate-200 dark:border-slate-600 text-slate-400 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-600 dark:peer-checked:bg-emerald-900/30 dark:peer-checked:text-emerald-400 transition" title="Hadir"><i class="fas fa-check"></i></div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="status[${record.id}]" value="izin" class="peer sr-only" ${record.status === 'izin' ? 'checked' : ''}>
                        <div class="w-8 h-8 flex items-center justify-center rounded-lg border-2 border-slate-200 dark:border-slate-600 text-slate-400 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-600 dark:peer-checked:bg-blue-900/30 dark:peer-checked:text-blue-400 transition" title="Izin"><i class="fas fa-envelope-open-text text-xs"></i></div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="status[${record.id}]" value="sakit" class="peer sr-only" ${record.status === 'sakit' ? 'checked' : ''}>
                        <div class="w-8 h-8 flex items-center justify-center rounded-lg border-2 border-slate-200 dark:border-slate-600 text-slate-400 peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-600 dark:peer-checked:bg-amber-900/30 dark:peer-checked:text-amber-400 transition" title="Sakit"><i class="fas fa-notes-medical text-xs"></i></div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="status[${record.id}]" value="alpha" class="peer sr-only" ${record.status === 'alpha' ? 'checked' : ''}>
                        <div class="w-8 h-8 flex items-center justify-center rounded-lg border-2 border-slate-200 dark:border-slate-600 text-slate-400 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-600 dark:peer-checked:bg-red-900/30 dark:peer-checked:text-red-400 transition" title="Alpha"><i class="fas fa-times"></i></div>
                    </label>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });

    document.getElementById('detail-modal').classList.remove('hidden');
    document.getElementById('detail-modal').classList.add('flex');
}

function closeDetailModal() {
    document.getElementById('detail-modal').classList.add('hidden');
    document.getElementById('detail-modal').classList.remove('flex');
}

document.getElementById('detail-modal').addEventListener('click', function(e) { if (e.target === this) closeDetailModal(); });
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeDetailModal(); });
</script>
@endpush
