@extends('layouts.dashboard', ['activePage' => 'programs'])
@section('title', 'Kelola Program Studi - Admin Akademik - Polimicro')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div><h1 class="text-2xl font-bold text-gray-900">Kelola Program Studi</h1><p class="text-gray-500">Tambah dan kelola prodi microcredential</p></div>
    <button onclick="openProdiModal()" class="px-5 py-3 btn-primary text-white rounded-xl font-semibold text-sm"><i class="fas fa-plus mr-2"></i>Tambah Prodi</button>
</div>
<div class="flex flex-wrap gap-4 mb-8">
    <div class="relative flex-1 min-w-[300px]">
        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
        <input type="text" id="prodiSearch" placeholder="Cari program studi..." class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 bg-white text-sm focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 outline-none transition-all">
    </div>
    <select id="statusFilter" class="px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm outline-none focus:ring-4 focus:ring-cyan-500/10">
        <option value="all">Semua Status</option>
        <option value="aktif">Aktif</option>
        <option value="nonaktif">Nonaktif</option>
    </select>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="prodiGrid">
    @foreach($prodiList as $p)
    @php $mkCount = $p->makul->count(); $enrollCount = $p->pendaftaranDiterima->count(); @endphp
    <div class="prodi-card bg-white rounded-3xl border border-slate-100 overflow-hidden card-hover group" data-nama="{{ strtolower($p->nama_prodi) }}" data-status="{{ $p->status }}">
        <div class="p-6">
            <div class="flex items-start justify-between mb-6">
                <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center text-3xl group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 shadow-inner">
                    {{ $p->icon }}
                </div>
                <div class="flex flex-col items-end gap-2">
                    @if($p->status === 'aktif')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wider border border-emerald-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold uppercase tracking-wider border border-slate-200">
                            Nonaktif
                        </span>
                    @endif
                </div>
            </div>

            <h3 class="font-bold text-slate-900 text-lg mb-2 group-hover:text-cyan-600 transition">{{ $p->nama_prodi }}</h3>
            <p class="text-slate-500 text-xs mb-6 line-clamp-2 leading-relaxed">{{ $p->deskripsi ?: 'Program studi unggulan dengan kurikulum standar industri.' }}</p>

            <div class="grid grid-cols-3 gap-3 mb-6">
                <div class="p-3 bg-slate-50 rounded-2xl text-center border border-transparent group-hover:border-cyan-100 transition">
                    <p class="text-xs font-bold text-slate-900">{{ $p->durasi }}</p>
                    <p class="text-[8px] font-bold text-slate-400 uppercase mt-0.5">Durasi</p>
                </div>
                <div class="p-3 bg-slate-50 rounded-2xl text-center border border-transparent group-hover:border-cyan-100 transition">
                    <p class="text-xs font-bold text-slate-900">{{ $mkCount }}</p>
                    <p class="text-[8px] font-bold text-slate-400 uppercase mt-0.5">Matkul</p>
                </div>
                <div class="p-3 bg-slate-50 rounded-2xl text-center border border-transparent group-hover:border-cyan-100 transition">
                    <p class="text-xs font-bold text-slate-900">{{ $enrollCount }}</p>
                    <p class="text-[8px] font-bold text-slate-400 uppercase mt-0.5">Mhs</p>
                </div>
            </div>

            <div class="flex gap-3">
                <button onclick="editProdi({{ $p->id }},'{{ addslashes($p->nama_prodi) }}','{{ addslashes($p->deskripsi) }}','{{ $p->durasi }}','{{ $p->icon }}','{{ $p->status }}')" class="flex-1 py-2.5 bg-cyan-50 text-cyan-600 rounded-xl text-xs font-bold hover:bg-cyan-100 transition flex items-center justify-center gap-2 border border-cyan-100">
                    <i class="fas fa-edit text-[10px]"></i> Edit
                </button>
                <form method="POST" action="{{ route('admin-akademik.programs.destroy', $p) }}" class="flex-1 delete-form">
                    @csrf @method('DELETE')
                    <button type="button" onclick="confirmDelete(this)" class="w-full py-2.5 bg-red-50 text-red-600 rounded-xl text-xs font-bold hover:bg-red-100 transition flex items-center justify-center gap-2">
                        <i class="fas fa-trash text-[10px]"></i> Hapus
                    </button>
                </form>
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
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Nama <span class="text-red-400">*</span></label><input type="text" name="nama_prodi" id="pf-nama" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 outline-none transition"></div>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Deskripsi <span class="text-red-400">*</span></label><textarea name="deskripsi" id="pf-desc" rows="3" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 outline-none transition"></textarea></div>
            <div class="grid grid-cols-3 gap-4">
                <div><label class="block text-sm font-medium text-slate-600 mb-1">Durasi <span class="text-red-400">*</span></label><input type="text" name="durasi" id="pf-durasi" placeholder="6 Bulan" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 outline-none transition"></div>
                <div><label class="block text-sm font-medium text-slate-600 mb-1">Icon</label><input type="text" name="icon" id="pf-icon" placeholder="💻" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 outline-none transition"></div>
                <div><label class="block text-sm font-medium text-slate-600 mb-1">Status</label><select name="status" id="pf-status" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 outline-none transition"><option value="aktif">Aktif</option><option value="nonaktif">Nonaktif</option></select></div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeProdiModal()" class="flex-1 py-3 rounded-xl border border-slate-200 text-slate-600 font-medium hover:bg-slate-50 transition">Batal</button>
                <button type="submit" data-submit class="flex-1 py-3 bg-cyan-600 text-white hover:bg-cyan-700 rounded-xl font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-cyan-600/20"><i class="fas fa-save text-sm"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
@endpush
@push('scripts')
<script>
// Search & Filter
const searchInput = document.getElementById('prodiSearch');
const statusFilter = document.getElementById('statusFilter');
const cards = document.querySelectorAll('.prodi-card');

function filterProdi() {
    const q = searchInput.value.toLowerCase();
    const s = statusFilter.value;
    
    cards.forEach(card => {
        const matchesSearch = card.dataset.nama.includes(q);
        const matchesStatus = s === 'all' || card.dataset.status === s;
        
        if (matchesSearch && matchesStatus) {
            card.style.display = '';
            card.classList.add('fade-in');
        } else {
            card.style.display = 'none';
        }
    });
}

searchInput.addEventListener('input', filterProdi);
statusFilter.addEventListener('change', filterProdi);

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

