@extends('layouts.dashboard', ['activePage' => 'materials'])
@section('title', 'Materi - Dosen - Polimicro')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div><h1 class="text-2xl font-bold text-gray-900">Kelola Materi</h1><p class="text-gray-500">Tambah, edit, atau hapus materi pembelajaran</p></div>
    <button onclick="document.getElementById('add-modal').classList.remove('hidden');document.getElementById('add-modal').classList.add('flex');" class="px-5 py-3 btn-primary text-white rounded-xl font-semibold text-sm"><i class="fas fa-plus mr-2"></i>Tambah Materi</button>
</div>
<select class="px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm mb-6" onchange="window.location='{{ route('dosen.materials') }}?matkul='+this.value">
    <option value="">Semua Matkul</option>
    @foreach($myMatkul as $m)<option value="{{ $m->id }}" {{ $filterMatkul == $m->id ? 'selected' : '' }}>{{ $m->nama_makul }}</option>@endforeach
</select>
@php $filteredMatkul = $filterMatkul ? $myMatkul->where('id', $filterMatkul) : $myMatkul; @endphp
@foreach($filteredMatkul as $m)
    @if($m->materi->count() > 0)
    <div class="bg-white rounded-2xl border border-gray-100 mb-4 overflow-hidden">
        <div class="p-5 border-b border-slate-50"><h3 class="font-bold">{{ $m->nama_makul }}</h3></div>
        <div class="divide-y divide-slate-50">
            @foreach($m->materi as $mat)
            <div class="p-5 flex items-center justify-between">
                <div>
                    <p class="font-semibold text-sm">{{ $mat->nama_materi }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ Str::limit($mat->deskripsi_materi, 60) }}</p>
                    @if($mat->file_materi)
                    <a href="{{ asset('storage/' . $mat->file_materi) }}" target="_blank" class="text-xs font-semibold text-cyan-600 hover:text-cyan-700 mt-2 inline-flex items-center"><i class="fas fa-file-download mr-1"></i>Unduh File Materi</a>
                    @else
                    <p class="text-xs text-slate-400 mt-2"><i class="fas fa-paperclip mr-1"></i>Tidak ada file</p>
                    @endif
                </div>
                <div class="flex gap-2">
                    <form method="POST" action="{{ route('dosen.materials.destroy', $mat) }}" onsubmit="return confirm('Hapus materi ini?')">@csrf @method('DELETE')<button class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-xs hover:bg-red-100"><i class="fas fa-trash"></i></button></form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
@endforeach

@push('modals')
{{-- Add Modal --}}
<div id="add-modal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background:rgba(15,23,42,0.6); backdrop-filter: blur(4px);">
    <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-lg w-full mx-4 fade-in">
        <h3 class="text-xl font-bold mb-4">Tambah Materi</h3>
        <form method="POST" action="{{ route('dosen.materials.store') }}" enctype="multipart/form-data" class="space-y-4">@csrf
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Mata Kuliah</label><select name="makul_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200">@foreach($myMatkul as $m)<option value="{{ $m->id }}">{{ $m->nama_makul }}</option>@endforeach</select></div>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Nama Materi</label><input type="text" name="nama_materi" required class="w-full px-4 py-3 rounded-xl border border-slate-200"></div>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Deskripsi</label><textarea name="deskripsi_materi" rows="3" required class="w-full px-4 py-3 rounded-xl border border-slate-200"></textarea></div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">File Materi (PDF/DOC/ZIP, Max: 2MB)</label>
                <input type="file" name="file_materi" accept=".pdf,.doc,.docx,.zip,.rar" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 transition">
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('add-modal').classList.add('hidden');document.getElementById('add-modal').classList.remove('flex');" class="flex-1 py-3 rounded-xl border border-slate-200 text-slate-600 font-medium">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-cyan-600 text-white rounded-xl font-semibold">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endpush
@endsection
