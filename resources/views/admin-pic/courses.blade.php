@extends('layouts.dashboard', ['activePage' => 'courses'])
@section('title', 'Kelola Mata Kuliah - Admin PIC - Polimicro')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div><h1 class="text-2xl font-bold text-gray-900">Kelola Mata Kuliah</h1><p class="text-gray-500">Kelola mata kuliah per program studi</p></div>
    <button onclick="document.getElementById('mk-modal').classList.remove('hidden');document.getElementById('mk-modal').classList.add('flex');document.getElementById('mkm-title').textContent='Tambah Mata Kuliah';document.getElementById('mk-form').action='{{ route('admin-pic.courses.store') }}';document.getElementById('mk-method').innerHTML='';" class="px-5 py-3 btn-primary text-white rounded-xl font-semibold text-sm"><i class="fas fa-plus mr-2"></i>Tambah Matkul</button>
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
                    <form method="POST" action="{{ route('admin-pic.courses.destroy', $m) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-xs hover:bg-red-100"><i class="fas fa-trash"></i></button></form>
                </div></td>
            </tr>
        @empty
            <tr><td colspan="5" class="px-5 py-12 text-center text-gray-400">Tidak ada data</td></tr>
        @endforelse
        </tbody>
    </table></div>
</div>
{{-- Modal --}}
<div id="mk-modal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background:rgba(0,0,0,0.4)">
    <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-lg w-full mx-4 fade-in">
        <h3 class="text-xl font-bold mb-4" id="mkm-title">Tambah Mata Kuliah</h3>
        <form id="mk-form" method="POST" action="{{ route('admin-pic.courses.store') }}" class="space-y-4">@csrf <span id="mk-method"></span>
            <div><label class="block text-sm font-medium text-gray-600 mb-1">Nama Mata Kuliah</label><input type="text" name="nama_makul" id="mkf-nama" required class="w-full px-4 py-3 rounded-xl border border-gray-200"></div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-gray-600 mb-1">Program Studi</label><select name="prodi_id" id="mkf-prodi" required class="w-full px-4 py-3 rounded-xl border border-gray-200">@foreach($prodiList as $p)<option value="{{ $p->id }}">{{ $p->nama_prodi }}</option>@endforeach</select></div>
                <div><label class="block text-sm font-medium text-gray-600 mb-1">Dosen Pengampu</label><select name="dosen_id" id="mkf-dosen" required class="w-full px-4 py-3 rounded-xl border border-gray-200">@foreach($dosenList as $d)<option value="{{ $d->id }}">{{ $d->name }}</option>@endforeach</select></div>
            </div>
            <div><label class="block text-sm font-medium text-gray-600 mb-1">Deskripsi</label><textarea name="deskripsi" id="mkf-desc" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200"></textarea></div>
            <div><label class="block text-sm font-medium text-gray-600 mb-1">SKS</label><input type="number" name="sks" id="mkf-sks" value="3" min="1" max="6" class="w-full px-4 py-3 rounded-xl border border-gray-200"></div>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('mk-modal').classList.add('hidden');document.getElementById('mk-modal').classList.remove('flex');" class="flex-1 py-3 rounded-xl border border-gray-200 text-gray-600 font-medium">Batal</button>
                <button type="submit" class="flex-1 py-3 btn-primary text-white rounded-xl font-semibold">Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
function editMK(id,nama,prodi,dosen,desc,sks){
    document.getElementById('mkm-title').textContent='Edit Mata Kuliah';
    document.getElementById('mk-form').action='/admin-pic/courses/'+id;
    document.getElementById('mk-method').innerHTML='<input type="hidden" name="_method" value="PUT">';
    document.getElementById('mkf-nama').value=nama;
    document.getElementById('mkf-prodi').value=prodi;
    document.getElementById('mkf-dosen').value=dosen;
    document.getElementById('mkf-desc').value=desc;
    document.getElementById('mkf-sks').value=sks;
    document.getElementById('mk-modal').classList.remove('hidden');document.getElementById('mk-modal').classList.add('flex');
}
</script>
@endsection
