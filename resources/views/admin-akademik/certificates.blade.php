@extends('layouts.dashboard', ['activePage' => 'certificates'])
@section('title', 'Kelola Sertifikat - Admin Akademik - Polimicro')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div><h1 class="text-2xl font-bold text-gray-900">Kelola Sertifikat</h1><p class="text-gray-500">Terbitkan dan kelola sertifikat kelulusan</p></div>
    <button onclick="openCertModal()" class="px-5 py-3 btn-primary text-white rounded-xl font-semibold text-sm"><i class="fas fa-plus mr-2"></i>Terbitkan Sertifikat</button>
</div>
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto"><table class="w-full text-sm">
        <thead><tr class="bg-slate-50 border-b border-slate-100"><th class="px-5 py-3 text-left font-semibold text-slate-600">No. Sertifikat</th><th class="px-5 py-3 text-left font-semibold text-slate-600">Mahasiswa</th><th class="px-5 py-3 text-left font-semibold text-slate-600">Program Studi</th><th class="px-5 py-3 text-left font-semibold text-slate-600">File & Tanggal</th><th class="px-5 py-3 text-center font-semibold text-slate-600">Status</th><th class="px-5 py-3 text-center font-semibold text-slate-600">Aksi</th></tr></thead>
        <tbody class="divide-y divide-slate-50">
        @forelse($certs as $c)
            <tr class="hover:bg-slate-50/50 transition">
                <td class="px-5 py-4 font-mono text-xs font-medium text-slate-700">{{ $c->nomor_sertifikat }}</td>
                <td class="px-5 py-4"><div class="flex items-center gap-2"><div class="w-8 h-8 rounded-full bg-cyan-100 flex items-center justify-center text-xs font-bold text-cyan-700">{{ $c->mahasiswa ? $c->mahasiswa->getInitials() : '?' }}</div><span class="font-medium text-sm text-slate-800">{{ $c->mahasiswa->name ?? '-' }}</span></div></td>
                <td class="px-5 py-4 text-slate-600 text-sm">{{ $c->prodi->nama_prodi ?? '-' }}</td>
                <td class="px-5 py-4">
                    <p class="text-slate-500 text-xs mb-1">{{ $c->tanggal_terbit->format('d/m/Y') }}</p>
                    @if($c->file_sertifikat)
                        <a href="{{ asset('storage/' . $c->file_sertifikat) }}" target="_blank" class="text-cyan-600 hover:text-cyan-700 font-semibold text-xs inline-flex items-center"><i class="fas fa-file-pdf mr-1"></i>Unduh</a>
                    @else
                        <span class="text-xs text-slate-400">-</span>
                    @endif
                </td>
                <td class="px-5 py-4 text-center"><span class="px-3 py-1 rounded-full text-xs font-semibold bg-cyan-50 text-cyan-700">{{ ucfirst($c->status) }}</span></td>
                <td class="px-5 py-4 text-center"><form method="POST" action="{{ route('admin-akademik.certificates.destroy', $c) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-xs hover:bg-red-100 transition"><i class="fas fa-trash"></i></button></form></td>
            </tr>
        @empty
            <tr><td colspan="6" class="px-5 py-12 text-center text-slate-400"><i class="fas fa-certificate text-3xl mb-3 block"></i>Belum ada sertifikat diterbitkan</td></tr>
        @endforelse
        </tbody>
    </table></div>
</div>

@push('modals')
<div id="cert-modal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background:rgba(15,23,42,0.6); backdrop-filter: blur(4px);">
    <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-lg w-full mx-4 fade-in">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold font-serif text-slate-800">Terbitkan Sertifikat Baru</h3>
            <button type="button" onclick="closeCertModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 transition"><i class="fas fa-times text-sm"></i></button>
        </div>
        <form method="POST" action="{{ route('admin-akademik.certificates.store') }}" enctype="multipart/form-data" class="space-y-4" onsubmit="this.querySelector('[data-submit]').disabled=true;this.querySelector('[data-submit]').innerHTML='<i class=\'fas fa-spinner fa-spin text-sm\'></i> Menerbitkan...'">@csrf
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Mahasiswa <span class="text-red-400">*</span></label><select name="mahasiswa_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition">@foreach($mahasiswaList as $m)<option value="{{ $m->id }}">{{ $m->name }} ({{ $m->nim }})</option>@endforeach</select></div>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Program Studi <span class="text-red-400">*</span></label><select name="prodi_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition">@foreach($prodiList as $p)<option value="{{ $p->id }}">{{ $p->nama_prodi }}</option>@endforeach</select></div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-600 mb-1">Nomor Sertifikat <span class="text-red-400">*</span></label><input type="text" name="nomor_sertifikat" value="CERT-PM-{{ date('Y') }}-{{ str_pad($certs->count()+1, 3, '0', STR_PAD_LEFT) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></div>
                <div><label class="block text-sm font-medium text-slate-600 mb-1">Tanggal Terbit <span class="text-red-400">*</span></label><input type="date" name="tanggal_terbit" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">File Sertifikat (PDF/JPG/PNG, Max: 2MB) <span class="text-red-400">*</span></label>
                <input type="file" name="file_sertifikat" required accept=".pdf,.jpg,.jpeg,.png" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeCertModal()" class="flex-1 py-3 rounded-xl border border-slate-200 text-slate-600 font-medium hover:bg-slate-50 transition">Batal</button>
                <button type="submit" data-submit class="flex-1 py-3 bg-cyan-600 text-white hover:bg-cyan-700 rounded-xl font-semibold transition flex items-center justify-center gap-2"><i class="fas fa-certificate text-sm"></i> Terbitkan</button>
            </div>
        </form>
    </div>
</div>
@endpush
@push('scripts')
<script>
function openCertModal() { document.getElementById('cert-modal').classList.remove('hidden'); document.getElementById('cert-modal').classList.add('flex'); }
function closeCertModal() { document.getElementById('cert-modal').classList.add('hidden'); document.getElementById('cert-modal').classList.remove('flex'); }
document.getElementById('cert-modal').addEventListener('click', function(e) { if (e.target === this) closeCertModal(); });
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeCertModal(); });
</script>
@endpush
@endsection

