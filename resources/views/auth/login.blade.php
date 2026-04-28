<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Polimicro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('design-assets/css/custom.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="min-h-screen flex bg-slate-50 text-slate-800">
    {{-- Left Panel --}}
    <div class="hidden lg:flex lg:w-1/2 items-center justify-center p-12 relative overflow-hidden" style="background:var(--slate-900)">
        <div class="absolute inset-0 opacity-10"><div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full blur-3xl"></div></div>
        <div class="relative z-10 text-center">
            <div class="w-20 h-20 mx-auto rounded-2xl bg-white/10 backdrop-blur border border-white/5 flex items-center justify-center mb-8"><i class="fas fa-graduation-cap text-4xl text-cyan-400"></i></div>
            <h2 class="text-4xl font-bold font-serif mb-4 text-white">Selamat Datang Kembali!</h2>
            <p class="text-slate-300 text-lg max-w-md mx-auto">Masuk ke akun Polimicro Anda untuk melanjutkan perjalanan belajar microcredential.</p>
            <div class="mt-10 flex justify-center gap-6">
                <div class="text-center"><div class="text-2xl font-bold text-white">500+</div><div class="text-cyan-200 text-sm">Mahasiswa</div></div>
                <div class="w-px bg-white/20"></div>
                <div class="text-center"><div class="text-2xl font-bold text-white">50+</div><div class="text-cyan-200 text-sm">Program</div></div>
                <div class="w-px bg-white/20"></div>
                <div class="text-center"><div class="text-2xl font-bold text-white">95%</div><div class="text-cyan-200 text-sm">Lulus</div></div>
            </div>
        </div>
    </div>
    {{-- Right Panel --}}
    <div class="flex-1 flex items-center justify-center p-8 bg-slate-50">
        <div class="w-full max-w-md fade-in">
            <a href="{{ route('home') }}" class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 rounded-xl bg-cyan-600 flex items-center justify-center"><i class="fas fa-graduation-cap text-white"></i></div>
                <span class="text-2xl font-bold font-serif text-slate-800">Polimicro</span>
            </a>
            <h1 class="text-3xl font-bold font-serif text-slate-900 mb-2">Masuk ke Akun</h1>
            <p class="text-slate-500 mb-8">Masukkan email dan password Anda untuk melanjutkan</p>

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm">{{ $errors->first() }}</div>
            @endif
            @if(session('success'))
                <div class="mb-4 p-4 bg-cyan-50 border border-cyan-200 rounded-xl text-cyan-700 text-sm font-medium"><i class="fas fa-check-circle mr-2 text-cyan-600"></i>{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@polimicro.ac.id" class="w-full pl-11 pr-4 py-3.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500/20 transition">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="password" name="password" id="password" required placeholder="Masukkan password" class="w-full pl-11 pr-12 py-3.5 rounded-xl border border-slate-200 bg-white focus:outline-none focus:ring-2 focus:ring-cyan-500/20 transition">
                        <button type="button" onclick="const p=document.getElementById('password'),i=document.getElementById('eye-icon');p.type=p.type==='password'?'text':'password';i.classList.toggle('fa-eye');i.classList.toggle('fa-eye-slash');" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600"><i class="fas fa-eye" id="eye-icon"></i></button>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-cyan-600 focus:ring-cyan-500">
                        <span class="text-slate-600">Ingat Saya</span>
                    </label>
                    <a href="{{ route('forgot-password') }}" class="text-cyan-600 font-semibold hover:text-cyan-700">Lupa Password?</a>
                </div>
                <button type="submit" class="w-full py-3.5 bg-cyan-600 text-white hover:bg-cyan-700 rounded-xl font-semibold text-lg transition shadow-lg mt-2"><i class="fas fa-sign-in-alt mr-2"></i>Masuk Sekarang</button>
            </form>

            <div class="mt-8 p-4 bg-slate-50 rounded-xl border border-slate-100">
                <p class="text-xs font-semibold text-slate-700 mb-2"><i class="fas fa-info-circle mr-1"></i>Demo Login:</p>
                <div class="text-xs text-slate-600 space-y-1">
                    <p><b>Mahasiswa:</b> ahmad@student.polimicro.ac.id / mahasiswa123</p>
                    <p><b>Dosen:</b> hendra@dosen.polimicro.ac.id / dosen123</p>
                    <p><b>Admin PIC:</b> adminpic@polimicro.ac.id / adminpic123</p>
                    <p><b>Admin Akademik:</b> adminakademik@polimicro.ac.id / adminakademik123</p>
                </div>
            </div>
            <p class="text-center text-slate-500 mt-6">Belum punya akun? <a href="{{ route('register') }}" class="text-cyan-600 font-semibold hover:text-cyan-700">Daftar Sekarang</a></p>
        </div>
    </div>
</body>
</html>
