@extends('layouts.dashboard', ['activePage' => 'assignments'])
@section('title', 'Penugasan - Dosen - Polimicro')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div><h1 class="text-2xl font-bold text-gray-900">Kelola Tugas</h1><p class="text-gray-500">Buat dan kelola tugas untuk mahasiswa</p></div>
    <button onclick="openTugasModal()" class="px-5 py-3 btn-primary text-white rounded-xl font-semibold text-sm"><i class="fas fa-plus mr-2"></i>Buat Tugas</button>
</div>
@php $hasTugas = false; @endphp
@foreach($myMatkul as $m)
    @if($m->tugas->count() > 0)
    @php $hasTugas = true; @endphp
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
                    <button onclick="editTugas({{ $t->id }}, {{ $t->makul_id }}, '{{ addslashes($t->nama_tugas) }}', '{{ addslashes($t->deskripsi_tugas) }}', '{{ $t->tanggal_akhir_deadline?->format('Y-m-d') }}', {{ $t->max_nilai }})" class="px-3 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs hover:bg-blue-100"><i class="fas fa-edit"></i></button>
                    <form method="POST" action="{{ route('dosen.assignments.destroy', $t) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas {{ addslashes($t->nama_tugas) }}?')">@csrf @method('DELETE')<button class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-xs hover:bg-red-100"><i class="fas fa-trash"></i></button></form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
@endforeach

@if(!$hasTugas)
    <x-empty-state 
        icon="fas fa-clipboard-list" 
        title="Belum Ada Tugas" 
        description="Anda belum membuat penugasan untuk mahasiswa di mata kuliah Anda."
        actionText="Buat Tugas Pertama"
        actionOnClick="openTugasModal()"
        class="mt-10"
    />
@endif

@push('modals')
<div id="tugas-modal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background:rgba(15,23,42,0.6); backdrop-filter: blur(4px);">
    <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-lg w-full mx-4 fade-in">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold font-serif text-slate-800" id="modal-title">Buat Tugas Baru</h3>
            <button type="button" onclick="closeTugasModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 transition"><i class="fas fa-times text-sm"></i></button>
        </div>
        <form id="tugas-form" method="POST" action="{{ route('dosen.assignments.store') }}" enctype="multipart/form-data" class="space-y-4" onsubmit="this.querySelector('[data-submit]').disabled=true;this.querySelector('[data-submit]').innerHTML='<i class=\'fas fa-spinner fa-spin text-sm\'></i> Menyimpan...'">@csrf
            <div id="method-field"></div>
            <div><label class="block text-sm font-medium text-gray-600 mb-1">Mata Kuliah <span class="text-red-400">*</span></label><select name="makul_id" id="field-makul" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition">@foreach($myMatkul as $m)<option value="{{ $m->id }}">{{ $m->nama_makul }}</option>@endforeach</select></div>
            <div><label class="block text-sm font-medium text-gray-600 mb-1">Judul Tugas <span class="text-red-400">*</span></label><input type="text" name="nama_tugas" id="field-nama" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></div>
            <div><label class="block text-sm font-medium text-gray-600 mb-1">Deskripsi <span class="text-red-400">*</span></label><textarea name="deskripsi_tugas" id="field-deskripsi" rows="3" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></textarea></div>
            <div><label class="block text-sm font-medium text-gray-600 mb-1">File Tugas (Opsional)</label><input type="file" name="file_tugas" class="w-full text-xs file:mr-2 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-cyan-50 file:text-cyan-700"></div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-gray-600 mb-1">Deadline <span class="text-red-400">*</span></label><input type="date" name="tanggal_akhir_deadline" id="field-deadline" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></div>
                <div><label class="block text-sm font-medium text-gray-600 mb-1">Nilai Maks</label><input type="number" name="max_nilai" id="field-nilai" value="100" min="1" max="100" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeTugasModal()" class="flex-1 py-3 rounded-xl border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition">Batal</button>
                <button type="submit" data-submit class="flex-1 py-3 bg-cyan-600 text-white rounded-xl font-semibold hover:bg-cyan-700 transition flex items-center justify-center gap-2"><i class="fas fa-save text-sm"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
function openTugasModal() {
    document.getElementById('modal-title').innerText = 'Buat Tugas Baru';
    document.getElementById('tugas-form').action = "{{ route('dosen.assignments.store') }}";
    document.getElementById('method-field').innerHTML = '';
    document.getElementById('field-nama').value = '';
    document.getElementById('field-deskripsi').value = '';
    document.getElementById('field-deadline').value = '';
    document.getElementById('field-nilai').value = 100;
    document.getElementById('tugas-modal').classList.remove('hidden'); 
    document.getElementById('tugas-modal').classList.add('flex'); 
}
function editTugas(id, makulId, nama, deskripsi, deadline, nilai) {
    document.getElementById('modal-title').innerText = 'Edit Tugas';
    document.getElementById('tugas-form').action = "/dosen/assignments/" + id;
    document.getElementById('method-field').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('field-makul').value = makulId;
    document.getElementById('field-nama').value = nama;
    document.getElementById('field-deskripsi').value = deskripsi;
    document.getElementById('field-deadline').value = deadline;
    document.getElementById('field-nilai').value = nilai;
    document.getElementById('tugas-modal').classList.remove('hidden'); 
    document.getElementById('tugas-modal').classList.add('flex'); 
}
function closeTugasModal() { document.getElementById('tugas-modal').classList.add('hidden'); document.getElementById('tugas-modal').classList.remove('flex'); }
document.getElementById('tugas-modal').addEventListener('click', function(e) { if (e.target === this) closeTugasModal(); });
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeTugasModal(); });
</script>
@endpush
@endsection
