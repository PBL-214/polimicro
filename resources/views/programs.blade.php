<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Studi - Polimicro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('design-assets/css/custom.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 text-slate-800">
    <nav class="sticky top-0 z-50 border-b border-slate-200 px-6 py-4 flex items-center justify-between" style="background:rgba(255,255,255,0.95);backdrop-filter:blur(12px);">
        <a href="{{ route('home') }}" class="flex items-center gap-3"><div class="w-10 h-10 rounded-xl bg-cyan-600 flex items-center justify-center"><i class="fas fa-graduation-cap text-white"></i></div><span class="text-xl font-bold font-serif text-slate-800">Polimicro</span></a>
        <div class="flex items-center gap-4">
            @auth
                <div class="relative group">
                    <button class="flex items-center gap-2 px-3 py-2 rounded-xl border border-slate-200 hover:border-cyan-300 transition bg-white shadow-sm">
                        <div class="w-8 h-8 rounded-full bg-cyan-100 flex items-center justify-center text-cyan-700 font-bold text-sm">
                            {{ auth()->user()->getInitials() }}
                        </div>
                        <span class="text-sm font-medium text-slate-700 max-w-[100px] truncate hidden md:inline">{{ auth()->user()->name }}</span>
                        <i class="fas fa-chevron-down text-xs text-slate-400"></i>
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 py-2 z-50">
                        <a href="{{ route(auth()->user()->getDashboardRoute()) }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-cyan-50 hover:text-cyan-700 transition"><i class="fas fa-th-large mr-2"></i>Dasbor Saya</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition"><i class="fas fa-sign-out-alt mr-2"></i>Keluar</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:border-cyan-600 font-semibold text-sm transition">Masuk</a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 bg-cyan-600 text-white hover:bg-cyan-700 transition shadow-lg rounded-xl font-semibold text-sm">Daftar</a>
            @endauth
        </div>
    </nav>
    <div class="max-w-6xl mx-auto px-6 py-12 fade-in">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold font-serif text-slate-900 mb-3">Program Studi Microcredential</h1>
            <p class="text-slate-500 max-w-2xl mx-auto text-lg">Pilih program yang sesuai dengan minat dan kebutuhan karir Anda. Setiap program dirancang dengan kurikulum terkini.</p>
        </div>
        @if(session('success'))<div class="mb-8 p-4 bg-cyan-50 border border-cyan-200 rounded-xl text-cyan-700 font-medium text-sm text-center"><i class="fas fa-check-circle mr-2 text-cyan-600"></i>{{ session('success') }}</div>@endif
        @if(session('warning'))<div class="mb-8 p-4 bg-yellow-50 border border-yellow-200 rounded-xl text-yellow-700 font-medium text-sm text-center"><i class="fas fa-exclamation-triangle mr-2 text-yellow-600"></i>{{ session('warning') }}</div>@endif
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($prodiList as $p)
            @php 
                $mkCount = $p->makul->count(); 
                $enrollCount = $p->pendaftaranDiterima->count();
                $isEnrolled = false;
                if(auth()->check() && auth()->user()->isMahasiswa()){
                    $isEnrolled = \App\Models\Pendaftaran::where('mahasiswa_id', auth()->id())->where('prodi_id', $p->id)->exists();
                }
            @endphp
            <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-xl hover:border-cyan-200 transition-all duration-300 overflow-hidden relative">
                <div class="mb-4"><span class="text-4xl">{{ $p->icon }}</span></div>
                <h3 class="text-xl font-bold font-serif text-slate-900 mb-2">{{ $p->nama_prodi }}</h3>
                <p class="text-slate-500 text-sm mb-4 line-clamp-3">{{ $p->deskripsi }}</p>
                <div class="flex gap-3 text-xs text-slate-500 mb-6 font-medium">
                    <span class="px-3 py-1 bg-cyan-50 rounded-full text-cyan-700"><i class="fas fa-clock mr-1"></i>{{ $p->durasi }}</span>
                    <span class="px-3 py-1 bg-slate-100 rounded-full text-slate-600"><i class="fas fa-book mr-1"></i>{{ $mkCount }} Matkul</span>
                    <span class="px-3 py-1 bg-slate-100 rounded-full text-slate-600"><i class="fas fa-users mr-1"></i>{{ $enrollCount }}</span>
                </div>
                @auth
                    @if(auth()->user()->isMahasiswa())
                        @if($isEnrolled)
                            <button disabled class="w-full py-3 bg-slate-100 text-slate-400 rounded-xl font-semibold text-sm cursor-not-allowed"><i class="fas fa-check-circle mr-2"></i>Anda sudah terdaftar di program ini</button>
                        @else
                            <form method="POST" action="{{ route('programs.enroll') }}">@csrf
                                <input type="hidden" name="prodi_id" value="{{ $p->id }}">
                                <button type="submit" class="w-full py-3 bg-cyan-600 hover:bg-cyan-700 text-white rounded-xl font-semibold text-sm transition"><i class="fas fa-user-plus mr-2"></i>Daftar Sekarang</button>
                            </form>
                        @endif
                    @else
                        <p class="text-center text-slate-400 text-sm py-3 bg-slate-50 rounded-xl">Login sebagai mahasiswa untuk mendaftar</p>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="block text-center w-full py-3 bg-cyan-600 hover:bg-cyan-700 text-white rounded-xl font-semibold text-sm transition"><i class="fas fa-user-plus mr-2"></i>Daftar Sekarang</a>
                @endauth
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>
