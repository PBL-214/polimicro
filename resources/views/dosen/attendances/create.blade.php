@extends('layouts.dashboard')

@section('title', 'Catat Kehadiran - ' . $course->nama_makul)

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-4 mb-2">
        <a href="{{ route('dosen.courses.attendances.index', $course->id) }}" class="text-slate-400 hover:text-cyan-600 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Catat Kehadiran Baru</h1>
    </div>
    <p class="text-slate-500 dark:text-slate-400 ml-8">{{ $course->nama_makul }}</p>
</div>

<form method="POST" action="{{ route('dosen.courses.attendances.store', $course->id) }}" class="space-y-6" onsubmit="this.querySelector('[type=submit]').disabled=true;this.querySelector('[type=submit]').innerHTML='<i class=\'fas fa-spinner fa-spin mr-2\'></i> Menyimpan...'">
    @csrf
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
        <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-6 border-b border-slate-100 dark:border-slate-700 pb-4">Informasi Pertemuan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Pertemuan Ke- <span class="text-red-500">*</span></label>
                <input type="number" name="pertemuan_ke" value="{{ old('pertemuan_ke', $nextPertemuan) }}" required min="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 dark:text-white transition">
                @error('pertemuan_ke') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Tanggal Pertemuan <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 dark:text-white transition">
                @error('tanggal') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div class="md:col-span-2 lg:col-span-1">
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Topik/Catatan (Opsional)</label>
                <input type="text" name="catatan" value="{{ old('catatan') }}" placeholder="Materi yang dibahas..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 dark:text-white transition">
                @error('catatan') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h2 class="text-lg font-bold text-slate-800 dark:text-white">Daftar Mahasiswa ({{ $students->count() }})</h2>
            <div class="flex gap-2">
                <button type="button" onclick="setAll('hadir')" class="px-3 py-1.5 bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 rounded-lg text-xs font-bold hover:bg-emerald-100 dark:hover:bg-emerald-900/50 transition">Set Semua Hadir</button>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/50 border-b border-slate-200 dark:border-slate-700">
                        <th class="p-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">No</th>
                        <th class="p-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">NIM</th>
                        <th class="p-4 font-semibold text-slate-700 dark:text-slate-300 text-sm">Nama Mahasiswa</th>
                        <th class="p-4 font-semibold text-slate-700 dark:text-slate-300 text-sm text-center">Status Kehadiran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @foreach($students as $index => $student)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                            <td class="p-4 text-sm text-slate-500 dark:text-slate-400 font-medium">{{ $index + 1 }}</td>
                            <td class="p-4 text-sm text-slate-500 dark:text-slate-400 font-mono">{{ $student->nim }}</td>
                            <td class="p-4 text-sm font-bold text-slate-800 dark:text-slate-200">{{ $student->name }}</td>
                            <td class="p-4">
                                <div class="flex justify-center gap-3">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="status[{{ $student->id }}]" value="hadir" class="peer sr-only" required checked>
                                        <div class="w-10 h-10 flex items-center justify-center rounded-xl border-2 border-slate-200 dark:border-slate-600 text-slate-400 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-600 dark:peer-checked:bg-emerald-900/30 dark:peer-checked:text-emerald-400 transition" title="Hadir"><i class="fas fa-check"></i></div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="status[{{ $student->id }}]" value="izin" class="peer sr-only">
                                        <div class="w-10 h-10 flex items-center justify-center rounded-xl border-2 border-slate-200 dark:border-slate-600 text-slate-400 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-600 dark:peer-checked:bg-blue-900/30 dark:peer-checked:text-blue-400 transition" title="Izin"><i class="fas fa-envelope-open-text text-sm"></i></div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="status[{{ $student->id }}]" value="sakit" class="peer sr-only">
                                        <div class="w-10 h-10 flex items-center justify-center rounded-xl border-2 border-slate-200 dark:border-slate-600 text-slate-400 peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-600 dark:peer-checked:bg-amber-900/30 dark:peer-checked:text-amber-400 transition" title="Sakit"><i class="fas fa-notes-medical text-sm"></i></div>
                                    </label>
                                    <label class="cursor-pointer">
                                        <input type="radio" name="status[{{ $student->id }}]" value="alpha" class="peer sr-only">
                                        <div class="w-10 h-10 flex items-center justify-center rounded-xl border-2 border-slate-200 dark:border-slate-600 text-slate-400 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-600 dark:peer-checked:bg-red-900/30 dark:peer-checked:text-red-400 transition" title="Alpha"><i class="fas fa-times"></i></div>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-6 bg-slate-50 dark:bg-slate-700/30 border-t border-slate-100 dark:border-slate-700 flex justify-end">
            <button type="submit" class="px-8 py-3 bg-cyan-600 text-white rounded-xl font-bold shadow-md shadow-cyan-600/20 hover:bg-cyan-700 transition flex items-center gap-2">
                <i class="fas fa-save"></i> Simpan Data Kehadiran
            </button>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
function setAll(statusValue) {
    const radios = document.querySelectorAll(`input[type="radio"][value="${statusValue}"]`);
    radios.forEach(radio => radio.checked = true);
}
</script>
@endpush
