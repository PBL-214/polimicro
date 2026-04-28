@extends('layouts.dashboard', ['activePage' => 'assignments'])
@section('title', 'Penugasan - Dosen - Polimicro')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div><h1 class="text-2xl font-bold text-gray-900">Kelola Tugas</h1><p class="text-gray-500">Buat dan kelola tugas untuk mahasiswa</p></div>
    <button onclick="document.getElementById('tugas-modal').classList.remove('hidden');document.getElementById('tugas-modal').classList.add('flex');" class="px-5 py-3 btn-primary text-white rounded-xl font-semibold text-sm"><i class="fas fa-plus mr-2"></i>Buat Tugas</button>
</div>
@foreach($myMatkul as $m)
    @if($m->tugas->count() > 0)
    <div class="bg-white rounded-2xl border border-gray-100 mb-4 overflow-hidden">
        <div class="p-5 border-b border-gray-50"><h3 class="font-bold">{{ $m->nama_makul }}</h3></div>
        <div class="divide-y divide-gray-50">
            @foreach($m->tugas as $t)
            <div class="p-5 flex items-center justify-between">
                <div>
                    <p class="font-semibold">{{ $t->nama_tugas }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ Str::limit($t->deskripsi_tugas, 80) }}</p>
                    <div class="flex gap-4 mt-2 text-xs text-gray-400">
                        <span><i class="fas fa-calendar mr-1"></i>Deadline: {{ $t->tanggal_akhir_deadline?->format('d/m/Y') ?? '-' }}</span>
                        <span><i class="fas fa-star mr-1"></i>Maks: {{ $t->max_nilai }}</span>
                        <span><i class="fas fa-inbox mr-1"></i>{{ $t->submissions->count() }} pengumpulan</span>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('dosen.submissions', ['tugas' => $t->id]) }}" class="px-4 py-2 bg-cyan-50 text-cyan-600 rounded-lg text-xs hover:bg-cyan-100 font-medium"><i class="fas fa-eye mr-1"></i>Lihat</a>
                    <form method="POST" action="{{ route('dosen.assignments.destroy', $t) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-xs hover:bg-red-100"><i class="fas fa-trash"></i></button></form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
@endforeach
{{-- Create Modal --}}
<div id="tugas-modal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background:rgba(0,0,0,0.4)">
    <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-lg w-full mx-4 fade-in">
        <h3 class="text-xl font-bold mb-4">Buat Tugas Baru</h3>
        <form method="POST" action="{{ route('dosen.assignments.store') }}" enctype="multipart/form-data" class="space-y-4">@csrf
            <div><label class="block text-sm font-medium text-gray-600 mb-1">Mata Kuliah</label><select name="makul_id" required class="w-full px-4 py-3 rounded-xl border border-gray-200">@foreach($myMatkul as $m)<option value="{{ $m->id }}">{{ $m->nama_makul }}</option>@endforeach</select></div>
            <div><label class="block text-sm font-medium text-gray-600 mb-1">Judul Tugas</label><input type="text" name="nama_tugas" required class="w-full px-4 py-3 rounded-xl border border-gray-200"></div>
            <div><label class="block text-sm font-medium text-gray-600 mb-1">Deskripsi</label><textarea name="deskripsi_tugas" rows="3" required class="w-full px-4 py-3 rounded-xl border border-gray-200"></textarea></div>
            <div><label class="block text-sm font-medium text-gray-600 mb-1">File Tugas (Opsional)</label><input type="file" name="file_tugas" class="w-full text-xs file:mr-2 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-cyan-50 file:text-cyan-700"></div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-gray-600 mb-1">Deadline</label><input type="date" name="tanggal_akhir_deadline" required class="w-full px-4 py-3 rounded-xl border border-gray-200"></div>
                <div><label class="block text-sm font-medium text-gray-600 mb-1">Nilai Maks</label><input type="number" name="max_nilai" value="100" min="1" max="100" class="w-full px-4 py-3 rounded-xl border border-gray-200"></div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="document.getElementById('tugas-modal').classList.add('hidden');document.getElementById('tugas-modal').classList.remove('flex');" class="flex-1 py-3 rounded-xl border border-gray-200 text-gray-600 font-medium">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-cyan-600 text-white rounded-xl font-semibold">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
