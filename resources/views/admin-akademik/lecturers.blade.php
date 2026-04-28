@extends('layouts.dashboard', ['activePage' => 'lecturers'])
@section('title', 'Kelola Dosen - Admin Akademik - Polimicro')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div><h1 class="text-2xl font-bold text-gray-900">Kelola Data Dosen</h1><p class="text-gray-500">Tambah, edit, atau hapus data dosen</p></div>
    <button onclick="openDosenModal()" class="px-5 py-3 btn-primary text-white rounded-xl font-semibold text-sm"><i class="fas fa-plus mr-2"></i>Tambah Dosen</button>
</div>
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto"><table class="w-full text-sm">
        <thead><tr class="bg-gray-50" style="background:#faf8f5"><th class="px-5 py-3 text-left font-semibold text-gray-600">Dosen</th><th class="px-5 py-3 text-left font-semibold text-gray-600">NIP</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Homebase</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Email</th><th class="px-5 py-3 text-center font-semibold text-gray-600">Matkul</th><th class="px-5 py-3 text-center font-semibold text-gray-600">Aksi</th></tr></thead>
        <tbody class="divide-y divide-gray-50">
        @foreach($dosenList as $d)
            @php $mc = \App\Models\Makul::where('dosen_id', $d->id)->count(); @endphp
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-4"><div class="flex items-center gap-3"><div class="w-10 h-10 rounded-full gradient-primary flex items-center justify-center text-white text-xs font-bold">{{ $d->getInitials() }}</div><div><p class="font-medium">{{ $d->name }}</p><p class="text-xs text-gray-400">{{ $d->phone ?? '' }}</p></div></div></td>
                <td class="px-5 py-4 text-gray-500 font-mono text-xs">{{ $d->nip ?? '-' }}</td>
                <td class="px-5 py-4 text-gray-500 text-xs">
                    @if($d->homebase)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-cyan-50 text-cyan-700 font-medium">
                            <i class="fas fa-university text-[10px]"></i>{{ $d->homebase }}
                        </span>
                    @else
                        <span class="text-gray-300">—</span>
                    @endif
                </td>
                <td class="px-5 py-4 text-gray-500 text-xs">{{ $d->email }}</td>
                <td class="px-5 py-4 text-center"><span class="px-3 py-1 rounded-full text-xs font-semibold bg-cyan-100 text-cyan-700">{{ $mc }}</span></td>
                <td class="px-5 py-4 text-center"><div class="flex gap-2 justify-center">
                    <button onclick="editDosen({{ $d->id }},'{{ addslashes($d->name) }}','{{ $d->email }}','{{ $d->nip }}','{{ $d->phone }}','{{ addslashes($d->homebase ?? '') }}','{{ addslashes($d->address ?? '') }}')" class="px-3 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs hover:bg-blue-100 transition"><i class="fas fa-edit"></i></button>
                    <form method="POST" action="{{ route('admin-akademik.lecturers.destroy', $d) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dosen {{ addslashes($d->name) }}? Tindakan ini tidak dapat dibatalkan.')">@csrf @method('DELETE')<button class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-xs hover:bg-red-100 transition"><i class="fas fa-trash"></i></button></form>
                </div></td>
            </tr>
        @endforeach
        </tbody>
    </table></div>
</div>

<div class="mt-6">
    {{ $dosenList->links() }}
</div>

@push('modals')
{{-- Modal Tambah/Edit Dosen --}}
<div id="dosen-modal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background:rgba(15,23,42,0.6); backdrop-filter: blur(4px);">
    <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-lg w-full mx-4 fade-in">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold font-serif text-slate-800" id="dm-title">Tambah Dosen</h3>
            <button type="button" onclick="closeDosenModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 transition"><i class="fas fa-times text-sm"></i></button>
        </div>
        <form id="dosen-form" method="POST" action="{{ route('admin-akademik.lecturers.store') }}" class="space-y-4" onsubmit="disableSubmit(this)">@csrf <span id="dosen-method"></span>
            <div><label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap <span class="text-red-400">*</span></label><input type="text" name="name" id="df-nama" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition" placeholder="Masukkan nama lengkap"></div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-gray-600 mb-1">Email <span class="text-red-400">*</span></label><input type="email" name="email" id="df-email" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition" placeholder="email@example.com"></div>
                <div><label class="block text-sm font-medium text-gray-600 mb-1">NIP</label><input type="text" name="nip" id="df-nip" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition" placeholder="Nomor Induk Pegawai"></div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-gray-600 mb-1">No. Telepon</label><input type="tel" name="phone" id="df-phone" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition" placeholder="08xxxxxxxxxx"></div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Homebase</label>
                    <select name="homebase" id="df-homebase" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition bg-white appearance-none" style="background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%239ca3af%22 stroke-width=%222%22%3E%3Cpath d=%22M6 9l6 6 6-6%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 12px center; background-size: 16px;">
                        <option value="">— Pilih Homebase —</option>
                        @foreach($prodiList as $prodi)
                            <option value="{{ $prodi->nama_prodi }}">{{ $prodi->nama_prodi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div><label class="block text-sm font-medium text-gray-600 mb-1">Alamat</label><textarea name="address" id="df-address" rows="2" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition resize-none" placeholder="Alamat lengkap dosen"></textarea></div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeDosenModal()" class="flex-1 py-3 rounded-xl border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 transition">Batal</button>
                <button type="submit" id="btn-submit-dosen" class="flex-1 py-3 btn-primary text-white rounded-xl font-semibold transition flex items-center justify-center gap-2">
                    <i class="fas fa-save text-sm"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
function openDosenModal() {
    document.getElementById('dm-title').textContent = 'Tambah Dosen';
    document.getElementById('dosen-form').action = '{{ route('admin-akademik.lecturers.store') }}';
    document.getElementById('dosen-method').innerHTML = '';
    ['df-nama','df-email','df-nip','df-phone','df-address'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('df-homebase').value = '';
    resetSubmitBtn();
    document.getElementById('dosen-modal').classList.remove('hidden');
    document.getElementById('dosen-modal').classList.add('flex');
}

function editDosen(id, nama, email, nip, phone, homebase, address) {
    document.getElementById('dm-title').textContent = 'Edit Dosen';
    document.getElementById('dosen-form').action = '/admin-akademik/lecturers/' + id;
    document.getElementById('dosen-method').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('df-nama').value = nama;
    document.getElementById('df-email').value = email;
    document.getElementById('df-nip').value = nip;
    document.getElementById('df-phone').value = phone;
    document.getElementById('df-homebase').value = homebase;
    document.getElementById('df-address').value = address;
    resetSubmitBtn();
    document.getElementById('dosen-modal').classList.remove('hidden');
    document.getElementById('dosen-modal').classList.add('flex');
}

function closeDosenModal() {
    document.getElementById('dosen-modal').classList.add('hidden');
    document.getElementById('dosen-modal').classList.remove('flex');
}

function disableSubmit(form) {
    const btn = document.getElementById('btn-submit-dosen');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin text-sm"></i> Menyimpan...';
}

function resetSubmitBtn() {
    const btn = document.getElementById('btn-submit-dosen');
    btn.disabled = false;
    btn.innerHTML = '<i class="fas fa-save text-sm"></i> Simpan';
}

// Close modal on backdrop click
document.getElementById('dosen-modal').addEventListener('click', function(e) {
    if (e.target === this) closeDosenModal();
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDosenModal();
});
</script>
@endpush
@endsection
