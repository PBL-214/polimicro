@extends('layouts.dashboard', ['activePage' => 'programs'])
@section('title', 'Kelola Program Studi - Admin Akademik - Polimicro')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div><h1 class="text-2xl font-bold text-gray-900">Kelola Program Studi</h1><p class="text-gray-500">Tambah dan kelola prodi microcredential</p></div>
    <button onclick="openProdiModal()" class="px-5 py-3 btn-primary text-white rounded-xl font-semibold text-sm"><i class="fas fa-plus mr-2"></i>Tambah Prodi</button>
</div>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($prodiList as $p)
    @php $mkCount = $p->makul->count(); $enrollCount = $p->pendaftaranDiterima->count(); @endphp
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden card-hover">
        <div class="gradient-card p-5 flex items-center justify-between">
            <div><span class="text-3xl">{{ $p->icon }}</span><h3 class="font-bold text-cyan-900 mt-2">{{ $p->nama_prodi }}</h3></div>
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $p->status === 'aktif' ? 'bg-cyan-100 text-cyan-700' : 'bg-gray-100 text-gray-500' }}">{{ ucfirst($p->status) }}</span>
        </div>
        <div class="p-5">
            <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $p->deskripsi }}</p>
            <div class="grid grid-cols-3 gap-2 text-center mb-4">
                <div class="p-2 bg-gray-50 rounded-lg"><p class="font-bold text-sm">{{ $p->durasi }}</p><p class="text-[10px] text-gray-400">Durasi</p></div>
                <div class="p-2 bg-gray-50 rounded-lg"><p class="font-bold text-sm">{{ $mkCount }}</p><p class="text-[10px] text-gray-400">Matkul</p></div>
                <div class="p-2 bg-gray-50 rounded-lg"><p class="font-bold text-sm">{{ $enrollCount }}</p><p class="text-[10px] text-gray-400">Mahasiswa</p></div>
            </div>
            <div class="flex gap-2">
                <button onclick="editProdi({{ $p->id }},'{{ addslashes($p->nama_prodi) }}','{{ addslashes($p->deskripsi) }}','{{ $p->durasi }}','{{ $p->icon }}','{{ $p->status }}')" class="flex-1 py-2 bg-blue-50 text-blue-600 rounded-xl text-xs font-medium hover:bg-blue-100"><i class="fas fa-edit mr-1"></i>Edit</button>
                <form method="POST" action="{{ route('admin-akademik.programs.destroy', $p) }}" onsubmit="return confirm('Hapus?')" class="flex-1">@csrf @method('DELETE')<button class="w-full py-2 bg-red-50 text-red-600 rounded-xl text-xs font-medium hover:bg-red-100"><i class="fas fa-trash mr-1"></i>Hapus</button></form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-8">
    {{ $prodiList->links() }}
</div>
@push('modals')
<div id="prodi-modal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background:rgba(15,23,42,0.6); backdrop-filter: blur(4px);">
    <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-lg w-full mx-4 fade-in">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold font-serif text-slate-800" id="pm-title">Tambah Program Studi</h3>
            <button type="button" onclick="closeProdiModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 transition"><i class="fas fa-times text-sm"></i></button>
        </div>
        <form id="prodi-form" method="POST" action="{{ route('admin-akademik.programs.store') }}" class="space-y-4" onsubmit="this.querySelector('[data-submit]').disabled=true;this.querySelector('[data-submit]').innerHTML='<i class=\'fas fa-spinner fa-spin text-sm\'></i> Menyimpan...'">@csrf <span id="prodi-method"></span>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Nama <span class="text-red-400">*</span></label><input type="text" name="nama_prodi" id="pf-nama" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></div>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Deskripsi <span class="text-red-400">*</span></label><textarea name="deskripsi" id="pf-desc" rows="3" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></textarea></div>
            <div class="grid grid-cols-3 gap-4">
                <div><label class="block text-sm font-medium text-slate-600 mb-1">Durasi <span class="text-red-400">*</span></label><input type="text" name="durasi" id="pf-durasi" placeholder="6 Bulan" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></div>
                <div><label class="block text-sm font-medium text-slate-600 mb-1">Icon</label><input type="text" name="icon" id="pf-icon" placeholder="💻" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></div>
                <div><label class="block text-sm font-medium text-slate-600 mb-1">Status</label><select name="status" id="pf-status" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"><option value="aktif">Aktif</option><option value="nonaktif">Nonaktif</option></select></div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeProdiModal()" class="flex-1 py-3 rounded-xl border border-slate-200 text-slate-600 font-medium hover:bg-slate-50 transition">Batal</button>
                <button type="submit" data-submit class="flex-1 py-3 bg-cyan-600 text-white hover:bg-cyan-700 rounded-xl font-semibold transition flex items-center justify-center gap-2"><i class="fas fa-save text-sm"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
@endpush
@push('scripts')
<script>
function openProdiModal() {
    document.getElementById('pm-title').textContent='Tambah Program Studi';
    document.getElementById('prodi-form').action='{{ route('admin-akademik.programs.store') }}';
    document.getElementById('prodi-method').innerHTML='';
    ['pf-nama','pf-desc','pf-durasi','pf-icon'].forEach(id => document.getElementById(id).value='');
    document.getElementById('pf-status').value='aktif';
    const btn = document.querySelector('#prodi-form [data-submit]');
    btn.disabled = false; btn.innerHTML = '<i class="fas fa-save text-sm"></i> Simpan';
    document.getElementById('prodi-modal').classList.remove('hidden');
    document.getElementById('prodi-modal').classList.add('flex');
}
function editProdi(id,nama,desc,durasi,icon,status) {
    document.getElementById('pm-title').textContent='Edit Program Studi';
    document.getElementById('prodi-form').action='/admin-akademik/programs/'+id;
    document.getElementById('prodi-method').innerHTML='<input type="hidden" name="_method" value="PUT">';
    document.getElementById('pf-nama').value=nama;
    document.getElementById('pf-desc').value=desc;
    document.getElementById('pf-durasi').value=durasi;
    document.getElementById('pf-icon').value=icon;
    document.getElementById('pf-status').value=status;
    const btn = document.querySelector('#prodi-form [data-submit]');
    btn.disabled = false; btn.innerHTML = '<i class="fas fa-save text-sm"></i> Simpan';
    document.getElementById('prodi-modal').classList.remove('hidden');
    document.getElementById('prodi-modal').classList.add('flex');
}
function closeProdiModal() { document.getElementById('prodi-modal').classList.add('hidden'); document.getElementById('prodi-modal').classList.remove('flex'); }
document.getElementById('prodi-modal').addEventListener('click', function(e) { if (e.target === this) closeProdiModal(); });
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeProdiModal(); });
</script>
@endpush
@endsection

