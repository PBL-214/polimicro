@extends('layouts.dashboard', ['activePage' => 'materials'])
@section('title', 'Materi - Dosen - Polimicro')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div><h1 class="text-2xl font-bold text-gray-900">Kelola Materi</h1><p class="text-gray-500">Tambah, edit, atau hapus materi pembelajaran</p></div>
    <button onclick="openMateriModal()" class="px-5 py-3 btn-primary text-white rounded-xl font-semibold text-sm"><i class="fas fa-plus mr-2"></i>Tambah Materi</button>
</div>
<select class="px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm mb-6" onchange="window.location='{{ route('dosen.materials') }}?matkul='+this.value">
    <option value="">Semua Matkul</option>
    @foreach($myMatkul as $m)<option value="{{ $m->id }}" {{ $filterMatkul == $m->id ? 'selected' : '' }}>{{ $m->nama_makul }}</option>@endforeach
</select>
@php 
    $filteredMatkul = $filterMatkul ? $myMatkul->where('id', $filterMatkul) : $myMatkul; 
    $hasMateri = false; 
@endphp
@foreach($filteredMatkul as $m)
    @if($m->materi->count() > 0)
    @php $hasMateri = true; @endphp
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
                    <button onclick="editMateri({{ $mat->id }}, {{ $mat->makul_id }}, '{{ addslashes($mat->nama_materi) }}', '{{ addslashes($mat->deskripsi_materi) }}')" class="px-3 py-2 bg-cyan-50 text-cyan-600 rounded-lg text-xs hover:bg-cyan-100 transition border border-cyan-100"><i class="fas fa-edit"></i></button>
                    <form method="POST" action="{{ route('dosen.materials.destroy', $mat) }}" onsubmit="return confirm('Hapus materi ini?')">@csrf @method('DELETE')<button class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-xs hover:bg-red-100 transition border border-red-100"><i class="fas fa-trash"></i></button></form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
@endforeach

@if(!$hasMateri)
    <x-empty-state 
        icon="fas fa-file-invoice" 
        title="Belum Ada Materi" 
        description="Anda belum mengunggah materi pembelajaran untuk mata kuliah yang Anda ampu."
        actionText="Tambah Materi Pertama"
        actionOnClick="openMateriModal()"
        class="mt-10"
    />
@endif

@push('modals')
<div id="add-modal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background:rgba(15,23,42,0.6); backdrop-filter: blur(4px);">
    <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-lg w-full mx-4 fade-in">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold font-serif text-slate-800" id="modal-title">Tambah Materi</h3>
            <button type="button" onclick="closeMateriModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 transition"><i class="fas fa-times text-sm"></i></button>
        </div>
        <form id="materi-form" method="POST" action="{{ route('dosen.materials.store') }}" enctype="multipart/form-data" class="space-y-4" onsubmit="this.querySelector('[data-submit]').disabled=true;this.querySelector('[data-submit]').innerHTML='<i class=\'fas fa-spinner fa-spin text-sm\'></i> Menyimpan...'">@csrf
            <div id="method-field"></div>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Mata Kuliah <span class="text-red-400">*</span></label><select name="makul_id" id="field-makul" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition">@foreach($myMatkul as $m)<option value="{{ $m->id }}">{{ $m->nama_makul }}</option>@endforeach</select></div>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Nama Materi <span class="text-red-400">*</span></label><input type="text" name="nama_materi" id="field-nama" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></div>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Deskripsi <span class="text-red-400">*</span></label><textarea name="deskripsi_materi" id="field-deskripsi" rows="3" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></textarea></div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">File Materi (PDF/DOC/ZIP, Max: 2MB)</label>
                <input type="file" name="file_materi" accept=".pdf,.doc,.docx,.zip,.rar" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 transition">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeMateriModal()" class="flex-1 py-3 rounded-xl border border-slate-200 text-slate-600 font-medium hover:bg-slate-50 transition">Batal</button>
                <button type="submit" data-submit class="flex-1 py-3 bg-cyan-600 text-white rounded-xl font-semibold hover:bg-cyan-700 transition flex items-center justify-center gap-2"><i class="fas fa-save text-sm"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
@endpush
@push('scripts')
<script>
function openMateriModal() {
    document.getElementById('modal-title').innerText = 'Tambah Materi';
    document.getElementById('materi-form').action = "{{ route('dosen.materials.store') }}";
    document.getElementById('method-field').innerHTML = '';
    document.getElementById('field-nama').value = '';
    document.getElementById('field-deskripsi').value = '';
    document.getElementById('add-modal').classList.remove('hidden'); 
    document.getElementById('add-modal').classList.add('flex'); 
}
function editMateri(id, makulId, nama, deskripsi) {
    document.getElementById('modal-title').innerText = 'Edit Materi';
    document.getElementById('materi-form').action = "/dosen/materials/" + id;
    document.getElementById('method-field').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('field-makul').value = makulId;
    document.getElementById('field-nama').value = nama;
    document.getElementById('field-deskripsi').value = deskripsi;
    document.getElementById('add-modal').classList.remove('hidden'); 
    document.getElementById('add-modal').classList.add('flex'); 
}
function closeMateriModal() { document.getElementById('add-modal').classList.add('hidden'); document.getElementById('add-modal').classList.remove('flex'); }
document.getElementById('add-modal').addEventListener('click', function(e) { if (e.target === this) closeMateriModal(); });
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeMateriModal(); });
</script>
@endpush
@endsection

