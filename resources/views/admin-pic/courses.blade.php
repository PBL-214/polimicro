@extends('layouts.dashboard', ['activePage' => 'courses'])
@section('title', 'Kelola Mata Kuliah - Admin PIC - Polimicro')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div><h1 class="text-2xl font-bold text-gray-900">Kelola Mata Kuliah</h1><p class="text-gray-500">Kelola mata kuliah per program studi</p></div>
    <button onclick="openMKModal()" class="px-5 py-3 btn-primary text-white rounded-xl font-semibold text-sm"><i class="fas fa-plus mr-2"></i>Tambah Matkul</button>
</div>
<select class="px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm mb-6" onchange="window.location='{{ route('admin-pic.courses') }}?prodi='+this.value">
    <option value="all">Semua Prodi</option>
    @foreach($prodiList as $p)<option value="{{ $p->id }}" {{ $filter == $p->id ? 'selected' : '' }}>{{ $p->nama_prodi }}</option>@endforeach
</select>
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto"><table class="w-full text-sm">
        <thead><tr class="bg-gray-50" style="background:#faf8f5"><th class="px-5 py-3 text-left font-semibold text-gray-600">Mata Kuliah</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Prodi</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Dosen</th><th class="px-5 py-3 text-center font-semibold text-gray-600">SKS</th><th class="px-5 py-3 text-center font-semibold text-gray-600">Aksi</th></tr></thead>
        <tbody class="divide-y divide-gray-50">
        @forelse($matkuls as $m)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-4"><p class="font-medium">{{ $m->nama_makul }}</p><p class="text-xs text-gray-400 mt-1 max-w-xs truncate">{{ $m->deskripsi }}</p></td>
                <td class="px-5 py-4 text-gray-500">{{ $m->prodi->nama_prodi ?? '-' }}</td>
                <td class="px-5 py-4 text-gray-500 text-xs">{{ $m->dosen->name ?? '-' }}</td>
                <td class="px-5 py-4 text-center">{{ $m->sks }}</td>
                <td class="px-5 py-4 text-center"><div class="flex gap-2 justify-center">
                    <button onclick="editMK({{ $m->id }},'{{ addslashes($m->nama_makul) }}',{{ $m->prodi_id }},{{ $m->dosen_id }},'{{ addslashes($m->deskripsi) }}',{{ $m->sks }})" class="px-3 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs hover:bg-blue-100"><i class="fas fa-edit"></i></button>
                    <form method="POST" action="{{ route('admin-pic.courses.destroy', $m) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah {{ addslashes($m->nama_makul) }}?')">@csrf @method('DELETE')<button class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-xs hover:bg-red-100"><i class="fas fa-trash"></i></button></form>
                </div></td>
            </tr>
        @empty
            <tr><td colspan="5" class="px-5 py-12 text-center text-gray-400">Tidak ada data</td></tr>
        @endforelse
        </tbody>
    </table></div>
</div>

<div class="mt-6">
    {{ $matkuls->withQueryString()->links() }}
</div>

@push('modals')
<div id="mk-modal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background:rgba(15,23,42,0.6); backdrop-filter: blur(4px);">
    <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-lg w-full mx-4 fade-in">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold font-serif text-slate-800" id="mkm-title">Tambah Mata Kuliah</h3>
            <button type="button" onclick="closeMKModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 transition"><i class="fas fa-times text-sm"></i></button>
        </div>
        <form id="mk-form" method="POST" action="{{ route('admin-pic.courses.store') }}" class="space-y-4" onsubmit="this.querySelector('[data-submit]').disabled=true;this.querySelector('[data-submit]').innerHTML='<i class=\'fas fa-spinner fa-spin text-sm\'></i> Menyimpan...'">@csrf <span id="mk-method"></span>
            <div><label class="block text-sm font-medium text-gray-600 mb-1">Nama Mata Kuliah <span class="text-red-400">*</span></label><input type="text" name="nama_makul" id="mkf-nama" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-gray-600 mb-1">Program Studi <span class="text-red-400">*</span></label><select name="prodi_id" id="mkf-prodi" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition">@foreach($prodiList as $p)<option value="{{ $p->id }}">{{ $p->nama_prodi }}</option>@endforeach</select></div>
                <div><label class="block text-sm font-medium text-gray-600 mb-1">Dosen Pengampu <span class="text-red-400">*</span></label><select name="dosen_id" id="mkf-dosen" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition">@foreach($dosenList as $d)<option value="{{ $d->id }}">{{ $d->name }}</option>@endforeach</select></div>
            </div>
            <div><label class="block text-sm font-medium text-gray-600 mb-1">Deskripsi</label><textarea name="deskripsi" id="mkf-desc" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></textarea></div>
            <div><label class="block text-sm font-medium text-gray-600 mb-1">SKS</label><input type="number" name="sks" id="mkf-sks" value="3" min="1" max="6" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeMKModal()" class="flex-1 py-3 rounded-xl border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition">Batal</button>
                <button type="submit" data-submit class="flex-1 py-3 btn-primary text-white rounded-xl font-semibold transition flex items-center justify-center gap-2"><i class="fas fa-save text-sm"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
function openMKModal() {
    document.getElementById('mkm-title').textContent='Tambah Mata Kuliah';
    document.getElementById('mk-form').action='{{ route('admin-pic.courses.store') }}';
    document.getElementById('mk-method').innerHTML='';
    ['mkf-nama','mkf-desc'].forEach(id => document.getElementById(id).value='');
    document.getElementById('mkf-sks').value=3;
    document.getElementById('mk-modal').classList.remove('hidden');
    document.getElementById('mk-modal').classList.add('flex');
}
function editMK(id,nama,prodi,dosen,desc,sks) {
    document.getElementById('mkm-title').textContent='Edit Mata Kuliah';
    document.getElementById('mk-form').action='/admin-pic/courses/'+id;
    document.getElementById('mk-method').innerHTML='<input type="hidden" name="_method" value="PUT">';
    document.getElementById('mkf-nama').value=nama;
    document.getElementById('mkf-prodi').value=prodi;
    document.getElementById('mkf-dosen').value=dosen;
    document.getElementById('mkf-desc').value=desc;
    document.getElementById('mkf-sks').value=sks;
    document.getElementById('mk-modal').classList.remove('hidden');
    document.getElementById('mk-modal').classList.add('flex');
}
function closeMKModal() { document.getElementById('mk-modal').classList.add('hidden'); document.getElementById('mk-modal').classList.remove('flex'); }
document.getElementById('mk-modal').addEventListener('click', function(e) { if (e.target === this) closeMKModal(); });
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeMKModal(); });
</script>
@endpush
@endsection
