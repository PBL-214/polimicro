<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Polimicro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('design-assets/css/custom.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="min-h-screen flex bg-slate-50 text-slate-800">
    <div class="hidden lg:flex lg:w-1/2 items-center justify-center p-12 relative overflow-hidden" style="background:var(--slate-900)">
        <div class="absolute inset-0 opacity-10"><div class="absolute bottom-20 right-10 w-96 h-96 bg-cyan-300 rounded-full blur-3xl"></div></div>
        <div class="relative z-10 text-center">
            <div class="w-20 h-20 mx-auto rounded-2xl bg-white/10 backdrop-blur border border-white/5 flex items-center justify-center mb-8"><i class="fas fa-user-plus text-4xl text-cyan-400"></i></div>
            <h2 class="text-4xl font-bold font-serif mb-4 text-white">Mulai Perjalanan Anda!</h2>
            <p class="text-slate-300 text-lg max-w-md mx-auto">Daftarkan diri Anda untuk mengikuti program microcredential berkualitas di Polimicro.</p>
        </div>
    </div>
    <div class="flex-1 flex items-center justify-center p-8 bg-slate-50">
        <div class="w-full max-w-md fade-in">
            <a href="{{ route('home') }}" class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-xl bg-cyan-600 flex items-center justify-center"><i class="fas fa-graduation-cap text-white"></i></div>
                <span class="text-2xl font-bold font-serif text-slate-800">Polimicro</span>
            </a>
            <h1 class="text-3xl font-bold font-serif text-slate-900 mb-2">Buat Akun Baru</h1>
            <p class="text-slate-500 mb-6">Isi data diri Anda untuk mendaftar sebagai mahasiswa</p>
            @if($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm">{{ $errors->first() }}</div>
            @endif
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div><label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap</label>
                    <div class="relative"><i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan nama lengkap" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 bg-white transition"></div>
                </div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                    <div class="relative"><i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 bg-white transition"></div>
                </div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1.5">No. Telepon</label>
                    <div class="relative"><i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 bg-white transition"></div>
                </div>
                <div><label class="block text-sm font-medium text-slate-700 mb-1.5">Program Studi</label>
                    <div class="relative"><i class="fas fa-book absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <select name="prodi_id" required class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 bg-white transition appearance-none cursor-pointer">
                        <option value="" disabled selected>Pilih Program Studi</option>
                        @foreach($programs ?? [] as $program)
                            <option value="{{ $program->id }}">{{ $program->nama_prodi }}</option>
                        @endforeach
                    </select>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs pointer-events-none"></i>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
                        <div class="relative"><i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="password" name="password" required minlength="6" placeholder="Min. 6 char" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 bg-white transition"></div>
                    </div>
                    <div><label class="block text-sm font-medium text-slate-700 mb-1.5">Konfirmasi</label>
                        <div class="relative"><i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="password" name="password_confirmation" required placeholder="Ulangi" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 bg-white transition"></div>
                    </div>
                </div>
                <button type="submit" class="w-full py-3.5 bg-cyan-600 hover:bg-cyan-700 text-white rounded-xl font-semibold text-lg transition shadow-lg mt-2"><i class="fas fa-user-plus mr-2"></i>Daftar Sekarang</button>
            </form>
            <p class="text-center text-slate-500 mt-6">Sudah punya akun? <a href="{{ route('login') }}" class="text-cyan-600 font-semibold hover:text-cyan-700">Masuk</a></p>
        </div>
    </div>
</body>
</html>
