@extends('layouts.dashboard', ['activePage' => 'profile'])
@section('title', 'Profil - Polimicro')
@section('content')
<h1 class="text-2xl font-bold text-slate-900 mb-6">Pengaturan Profil</h1>
<div class="grid lg:grid-cols-3 gap-6"> 
    <div class="bg-white rounded-2xl border border-slate-100 p-6 text-center"> 
        <div class="w-24 h-24 mx-auto rounded-full gradient-primary flex items-center justify-center text-white text-3xl font-bold mb-4 relative group overflow-hidden shadow-lg"> 
            @if($user->avatar)
                <img src="{{ $user->getAvatarUrl() }}" class="w-full h-full object-cover" alt="Profile Picture">
            @else
                {{ $user->getInitials() }}
            @endif
            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center cursor-pointer" onclick="document.getElementById('avatar-upload').click()">
                <i class="fas fa-camera text-white text-xl"></i>
            </div>
        </div> 
        <form action="{{ route('mahasiswa.profile.avatar') }}" method="POST" enctype="multipart/form-data" id="avatar-form" class="hidden">
            @csrf
            <input type="file" name="avatar" id="avatar-upload" accept="image/*" onchange="document.getElementById('avatar-form').submit()">
        </form>
        <h3 class="font-bold text-lg">{{ $user->name }}</h3> <p class="text-slate-500 text-sm">{{ $user->email }}</p> <p class="text-xs mt-2"><span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->status === 'aktif' ? 'bg-cyan-100 text-cyan-700' : 'bg-yellow-100 text-yellow-700' }}">{{ ucfirst($user->status) }}</span></p> <p class="text-slate-400 text-xs mt-3">NIM: {{ $user->nim ?? '-' }}</p> 
    </div> 
    <div class="lg:col-span-2 space-y-6"> <div class="card-dashboard"> <h3 class="font-bold text-slate-900 mb-4"><i class="fas fa-user mr-2 text-cyan-600"></i>Data Pribadi</h3> @if($errors->any() && !$errors->has('old_password')) <div class="mb-4 p-3 bg-red-50 rounded-xl text-red-600 text-sm">{{ $errors->first() }}</div> @endif <form method="POST" action="{{ route('mahasiswa.profile.update') }}" class="space-y-4"> @csrf @method('PUT') <div class="grid md:grid-cols-2 gap-4"> <div><label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap</label><input type="text" name="nama" value="{{ $user->name }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white"></div> <div><label class="block text-sm font-medium text-gray-600 mb-1">Email</label><input type="email" value="{{ $user->email }}" disabled class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-slate-400"></div> <div><label class="block text-sm font-medium text-gray-600 mb-1">No. Telepon</label><input type="tel" name="phone" value="{{ $user->phone }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white"></div> <div><label class="block text-sm font-medium text-gray-600 mb-1">Alamat</label><input type="text" name="address" value="{{ $user->address }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-white"></div> </div> <button type="submit" class="px-6 py-3 btn-primary text-white font-semibold"><i class="fas fa-save mr-2"></i>Simpan Perubahan</button> </form> </div> <div class="card-dashboard"> <h3 class="font-bold text-slate-900 mb-4"><i class="fas fa-lock mr-2 text-cyan-600"></i>Ubah Password</h3> @if($errors->has('old_password')) <div class="mb-4 p-3 bg-red-50 rounded-xl text-red-600 text-sm">{{ $errors->first('old_password') }}</div> @endif <form method="POST" action="{{ route('mahasiswa.profile.password') }}" class="space-y-4"> @csrf @method('PUT') <div><label class="block text-sm font-medium text-gray-600 mb-1">Password Lama</label><input type="password" name="old_password" required class="w-full px-4 py-3 rounded-xl border border-gray-200"></div> <div class="grid md:grid-cols-2 gap-4"> <div><label class="block text-sm font-medium text-gray-600 mb-1">Password Baru</label><input type="password" name="new_password" required minlength="6" class="w-full px-4 py-3 rounded-xl border border-gray-200"></div> <div><label class="block text-sm font-medium text-gray-600 mb-1">Konfirmasi</label><input type="password" name="new_password_confirmation" required class="w-full px-4 py-3 rounded-xl border border-gray-200"></div> </div> <button type="submit" class="px-6 py-3 bg-gray-800 hover:bg-gray-900 text-white rounded-xl font-semibold transition"><i class="fas fa-key mr-2"></i>Ubah Password</button> </form> </div> </div>
</div>
@endsection
