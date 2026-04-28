@extends('layouts.dashboard', ['activePage' => 'lecturers'])
@section('title', 'Kelola Dosen - Admin Akademik - Polimicro')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div><h1 class="text-2xl font-bold text-gray-900">Kelola Data Dosen</h1><p class="text-gray-500">Tambah, edit, atau hapus data dosen</p></div>
    <button onclick="openDosenModal()" class="px-5 py-3 btn-primary text-white rounded-xl font-semibold text-sm"><i class="fas fa-plus mr-2"></i>Tambah Dosen</button>
</div>
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto"><table class="w-full text-sm">
        <thead><tr class="bg-gray-50" style="background:#faf8f5"><th class="px-5 py-3 text-left font-semibold text-gray-600">Dosen</th><th class="px-5 py-3 text-left font-semibold text-gray-600">NIP</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Bidang</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Email</th><th class="px-5 py-3 text-center font-semibold text-gray-600">Matkul</th><th class="px-5 py-3 text-center font-semibold text-gray-600">Aksi</th></tr></thead>
        <tbody class="divide-y divide-gray-50">
        @foreach($dosenList as $d)
            @php $mc = \App\Models\Makul::where('dosen_id', $d->id)->count(); @endphp
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-4"><div class="flex items-center gap-3"><div class="w-10 h-10 rounded-full gradient-primary flex items-center justify-center text-white text-xs font-bold">{{ $d->getInitials() }}</div><div><p class="font-medium">{{ $d->name }}</p><p class="text-xs text-gray-400">{{ $d->phone ?? '' }}</p></div></div></td>
                <td class="px-5 py-4 text-gray-500 font-mono text-xs">{{ $d->nip ?? '-' }}</td>
                <td class="px-5 py-4 text-gray-500 text-xs">{{ $d->bidang ?? '-' }}</td>
                <td class="px-5 py-4 text-gray-500 text-xs">{{ $d->email }}</td>
                <td class="px-5 py-4 text-center"><span class="px-3 py-1 rounded-full text-xs font-semibold bg-cyan-100 text-cyan-700">{{ $mc }}</span></td>
                <td class="px-5 py-4 text-center"><div class="flex gap-2 justify-center">
                    <button onclick="editDosen({{ $d->id }},'{{ addslashes($d->name) }}','{{ $d->email }}','{{ $d->nip }}','{{ $d->phone }}','{{ addslashes($d->bidang ?? '') }}','{{ addslashes($d->address ?? '') }}')" class="px-3 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs hover:bg-blue-100"><i class="fas fa-edit"></i></button>
                    <form method="POST" action="{{ route('admin-akademik.lecturers.destroy', $d) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-xs hover:bg-red-100"><i class="fas fa-trash"></i></button></form>
                </div></td>
            </tr>
        @endforeach
        </tbody>
    </table></div>
</div>
{{-- Modal --}}
<div id="dosen-modal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background:rgba(0,0,0,0.4)">
    <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-lg w-full mx-4 fade-in">
        <h3 class="text-xl font-bold mb-4" id="dm-title">Tambah Dosen</h3>
        <form id="dosen-form" method="POST" action="{{ route('admin-akademik.lecturers.store') }}" class="space-y-4">@csrf <span id="dosen-method"></span>
            <div><label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap</label><input type="text" name="name" id="df-nama" required class="w-full px-4 py-3 rounded-xl border border-gray-200"></div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-gray-600 mb-1">Email</label><input type="email" name="email" id="df-email" required class="w-full px-4 py-3 rounded-xl border border-gray-200"></div>
                <div><label class="block text-sm font-medium text-gray-600 mb-1">NIP</label><input type="text" name="nip" id="df-nip" class="w-full px-4 py-3 rounded-xl border border-gray-200"></div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-gray-600 mb-1">No. Telepon</label><input type="tel" name="phone" id="df-phone" class="w-full px-4 py-3 rounded-xl border border-gray-200"></div>
                <div><label class="block text-sm font-medium text-gray-600 mb-1">Bidang</label><input type="text" name="bidang" id="df-bidang" class="w-full px-4 py-3 rounded-xl border border-gray-200"></div>
            </div>
            <div><label class="block text-sm font-medium text-gray-600 mb-1">Alamat</label><input type="text" name="address" id="df-address" class="w-full px-4 py-3 rounded-xl border border-gray-200"></div>
            <div class="flex gap-3">
                <button type="button" onclick="closeDosenModal()" class="flex-1 py-3 rounded-xl border border-gray-200 text-gray-600 font-medium">Batal</button>
                <button type="submit" class="flex-1 py-3 btn-primary text-white rounded-xl font-semibold">Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
function openDosenModal(){document.getElementById('dm-title').textContent='Tambah Dosen';document.getElementById('dosen-form').action='{{ route('admin-akademik.lecturers.store') }}';document.getElementById('dosen-method').innerHTML='';['df-nama','df-email','df-nip','df-phone','df-bidang','df-address'].forEach(id=>document.getElementById(id).value='');document.getElementById('dosen-modal').classList.remove('hidden');document.getElementById('dosen-modal').classList.add('flex');}
function editDosen(id,nama,email,nip,phone,bidang,address){document.getElementById('dm-title').textContent='Edit Dosen';document.getElementById('dosen-form').action='/admin-akademik/lecturers/'+id;document.getElementById('dosen-method').innerHTML='<input type="hidden" name="_method" value="PUT">';document.getElementById('df-nama').value=nama;document.getElementById('df-email').value=email;document.getElementById('df-nip').value=nip;document.getElementById('df-phone').value=phone;document.getElementById('df-bidang').value=bidang;document.getElementById('df-address').value=address;document.getElementById('dosen-modal').classList.remove('hidden');document.getElementById('dosen-modal').classList.add('flex');}
function closeDosenModal(){document.getElementById('dosen-modal').classList.add('hidden');document.getElementById('dosen-modal').classList.remove('flex');}
</script>
@endsection
