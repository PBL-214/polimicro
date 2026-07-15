@extends('layouts.dashboard', ['activePage' => 'profile'])
@section('title', 'Profil Dosen - Polimicro')
@section('content')
<h1 class="text-2xl font-bold text-slate-900 mb-6 font-serif">Pengaturan Profil</h1>
<div class="grid lg:grid-cols-3 gap-6"> 
    <div class="bg-white rounded-[2rem] border border-gray-100 p-8 text-center shadow-sm"> 
        <div class="w-32 h-32 mx-auto rounded-3xl bg-gradient-to-br from-cyan-500 to-cyan-700 flex items-center justify-center text-white text-4xl font-bold mb-6 shadow-lg shadow-cyan-500/30 relative group overflow-hidden"> 
            @if($user->avatar)
                <img src="{{ $user->getAvatarUrl() }}" class="w-full h-full object-cover" alt="Profile Picture">
            @else
                {{ $user->getInitials() }}
            @endif
            <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition flex items-center justify-center cursor-pointer" onclick="document.getElementById('avatar-upload').click()">
                <i class="fas fa-camera text-white text-2xl"></i>
            </div>
        </div> 
        <form action="{{ route('dosen.profile.avatar') }}" method="POST" enctype="multipart/form-data" id="avatar-form" class="hidden">
            @csrf
            <input type="file" name="avatar" id="avatar-upload" accept="image/*" onchange="document.getElementById('avatar-form').submit()">
        </form>
        <h3 class="font-bold text-xl text-slate-900">{{ $user->name }}</h3> 
        <p class="text-slate-500 text-sm mt-1">{{ $user->email }}</p> 
        <p class="text-xs mt-4"><span class="px-4 py-1.5 rounded-xl text-xs font-bold {{ $user->status === 'aktif' ? 'bg-cyan-50 text-cyan-700 border border-cyan-100' : 'bg-amber-50 text-amber-700 border border-amber-100' }} uppercase tracking-wider">{{ ucfirst($user->status) }}</span></p> 
        <div class="mt-6 pt-6 border-t border-slate-100">
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Peran</p>
            <p class="text-slate-700 font-bold mt-1">Dosen Pengampu</p>
        </div>
    </div> 
    
    <div class="lg:col-span-2 space-y-6"> 
        <div class="bg-white rounded-[2rem] border border-gray-100 p-8 shadow-sm"> 
            <h3 class="font-bold text-slate-900 mb-6 font-serif flex items-center gap-2"><i class="fas fa-user-edit text-cyan-600"></i>Data Pribadi</h3> 
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-700 text-sm font-semibold flex items-center gap-3">
                    <i class="fas fa-check-circle text-emerald-500 text-lg"></i> {{ session('success') }}
                </div>
            @endif
            @if($errors->any() && !$errors->has('current_password')) 
                <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl text-red-600 text-sm font-semibold flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-red-500 text-lg"></i> {{ $errors->first() }}
                </div> 
            @endif 
            <form method="POST" action="{{ route('dosen.profile.update') }}" class="space-y-5"> 
                @csrf 
                @method('PUT') 
                <div class="grid md:grid-cols-2 gap-5"> 
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-5 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition outline-none text-sm font-medium">
                    </div> 
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-5 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition outline-none text-sm font-medium">
                    </div> 
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">No. Telepon</label>
                        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-5 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition outline-none text-sm font-medium">
                    </div> 
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Alamat Lengkap</label>
                        <input type="text" name="address" value="{{ old('address', $user->address) }}" class="w-full px-5 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition outline-none text-sm font-medium">
                    </div> 
                </div> 
                <div class="pt-2">
                    <button type="submit" class="px-6 py-3 bg-cyan-600 hover:bg-cyan-700 text-white rounded-xl text-sm font-bold shadow-md shadow-cyan-600/20 transition active:scale-95 flex items-center justify-center gap-2"><i class="fas fa-save"></i>Simpan Perubahan</button> 
                </div>
            </form> 
        </div> 

        <div class="bg-white rounded-[2rem] border border-gray-100 p-8 shadow-sm"> 
            <h3 class="font-bold text-slate-900 mb-6 font-serif flex items-center gap-2"><i class="fas fa-shield-alt text-cyan-600"></i>Keamanan Akun</h3> 
            @if($errors->has('current_password') || $errors->has('password')) 
                <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl text-red-600 text-sm font-semibold flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-red-500 text-lg"></i> Terdapat kesalahan pada input password.
                </div> 
            @endif 
            <form method="POST" action="{{ route('dosen.profile.password') }}" class="space-y-5"> 
                @csrf 
                @method('PUT') 
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password Saat Ini</label>
                    <input type="password" name="current_password" required class="w-full px-5 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition outline-none text-sm font-medium">
                    @error('current_password')<span class="text-xs text-red-500 mt-1 block font-semibold">{{ $message }}</span>@enderror
                </div> 
                <div class="grid md:grid-cols-2 gap-5 pt-2 border-t border-slate-100 mt-5"> 
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password Baru</label>
                        <input type="password" name="password" required minlength="6" class="w-full px-5 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition outline-none text-sm font-medium">
                        @error('password')<span class="text-xs text-red-500 mt-1 block font-semibold">{{ $message }}</span>@enderror
                    </div> 
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" required class="w-full px-5 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 transition outline-none text-sm font-medium">
                    </div> 
                </div> 
                <div class="pt-2">
                    <button type="submit" class="px-6 py-3 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-bold shadow-md shadow-slate-800/20 transition active:scale-95 flex items-center justify-center gap-2"><i class="fas fa-key"></i>Perbarui Password</button> 
                </div>
            </form> 
        </div> 
    </div>
</div>
@endsection
