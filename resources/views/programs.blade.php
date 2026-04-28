<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Program - Polimicro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .mesh-gradient {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, hsla(187, 81%, 94%, 1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(215, 25%, 27%, 0.05) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(187, 81%, 94%, 1) 0, transparent 50%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }
        .program-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 60px -15px rgba(6, 182, 212, 0.15);
        }
        .hero-title {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="mesh-gradient min-h-screen text-slate-800">
    {{-- Navigation --}}
    <nav class="sticky top-0 z-50 px-8 py-5 flex items-center justify-between border-b border-white/20 glass-card">
        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
            <div class="w-11 h-11 rounded-2xl bg-cyan-600 flex items-center justify-center text-white shadow-lg shadow-cyan-600/20 group-hover:rotate-6 transition-transform">
                <i class="fas fa-graduation-cap text-lg"></i>
            </div>
            <span class="text-2xl font-bold font-serif tracking-tight text-slate-900">Polimicro</span>
        </a>
        <div class="flex items-center gap-6">
            @auth
                <a href="{{ route(auth()->user()->getDashboardRoute()) }}" class="flex items-center gap-3 px-4 py-2 rounded-2xl bg-white/50 border border-white hover:bg-white transition shadow-sm">
                    <div class="w-8 h-8 rounded-full bg-cyan-600 text-white flex items-center justify-center font-bold text-xs shadow-sm">{{ auth()->user()->getInitials() }}</div>
                    <span class="text-sm font-semibold text-slate-700 hidden md:inline">{{ auth()->user()->name }}</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 hover:text-cyan-600 transition">Masuk</a>
                <a href="{{ route('register') }}" class="px-6 py-3 bg-cyan-600 text-white rounded-2xl font-bold text-sm shadow-xl shadow-cyan-600/20 hover:bg-cyan-700 transition active:scale-95">Mulai Belajar</a>
            @endauth
        </div>
    </nav>

    {{-- Hero Section --}}
    <header class="max-w-6xl mx-auto px-6 pt-20 pb-16 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-cyan-50 border border-cyan-100 text-cyan-600 text-xs font-bold uppercase tracking-widest mb-6 animate-float">
            <i class="fas fa-sparkles"></i> Masa Depan Karir Anda Dimulai Di Sini
        </div>
        <h1 class="text-4xl md:text-7xl font-serif hero-title mb-6 leading-tight">Temukan Potensi <br>Terbaik Anda</h1>
        <p class="text-slate-500 max-w-2xl mx-auto text-lg leading-relaxed">
            Kurikulum microcredential yang dirancang bersama industri untuk membekali Anda dengan keahlian praktis yang paling dibutuhkan saat ini.
        </p>

        {{-- Search Bar --}}
        <div class="mt-12 max-w-xl mx-auto relative group">
            <div class="absolute inset-y-0 left-5 flex items-center text-slate-400 group-focus-within:text-cyan-600 transition-colors">
                <i class="fas fa-search"></i>
            </div>
            <input type="text" id="programSearch" placeholder="Cari program studi (misal: AI, Web, UI/UX...)" 
                class="w-full pl-14 pr-6 py-5 bg-white/70 backdrop-blur-xl border border-white rounded-[2rem] shadow-xl shadow-slate-200/50 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 outline-none transition-all text-slate-700 font-medium">
        </div>
    </header>

    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto px-6 pb-24">
        @if(session('success'))
            <div class="max-w-4xl mx-auto mb-10 p-5 bg-green-50 border border-green-100 rounded-3xl text-green-700 flex items-center gap-4 animate-bounce">
                <div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center flex-shrink-0 shadow-lg"><i class="fas fa-check"></i></div>
                <p class="font-semibold">{{ session('success') }}</p>
            </div>
        @endif

        <div class="swiper programsSwiper pb-16">
            <div class="swiper-wrapper">
                @foreach($prodiList as $p)
                @php 
                    $mkCount = $p->makul->count(); 
                    $enrollCount = $p->pendaftaranDiterima->count();
                    $isEnrolled = false;
                    if(auth()->check() && auth()->user()->isMahasiswa()){
                        $isEnrolled = \App\Models\Pendaftaran::where('mahasiswa_id', auth()->id())->where('prodi_id', $p->id)->exists();
                    }
                @endphp
                <div class="swiper-slide h-auto">
                    <div class="program-card glass-card rounded-[2.5rem] p-8 transition-all duration-500 flex flex-col h-full relative group">
                        {{-- Icon & Status --}}
                        <div class="flex justify-between items-start mb-8">
                            <div class="w-16 h-16 rounded-[1.5rem] bg-white shadow-xl shadow-slate-200/50 flex items-center justify-center text-4xl group-hover:scale-110 transition-transform duration-500">
                                {{ $p->icon }}
                            </div>
                            <span class="px-4 py-1.5 rounded-full bg-cyan-50 text-cyan-600 text-[10px] font-bold uppercase tracking-wider border border-cyan-100">
                                {{ $p->durasi }}
                            </span>
                        </div>

                        {{-- Info --}}
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold font-serif text-slate-900 mb-3 group-hover:text-cyan-600 transition-colors">{{ $p->nama_prodi }}</h3>
                            <p class="text-slate-500 text-sm leading-relaxed mb-8 line-clamp-3">
                                {{ $p->deskripsi ?: 'Pelajari keahlian mendalam dalam bidang ini dengan kurikulum yang terstruktur dan dimentoring oleh para profesional berpengalaman.' }}
                            </p>

                            <div class="flex items-center gap-6 mb-8 py-4 border-y border-slate-100">
                                <div class="flex flex-col">
                                    <span class="text-slate-900 font-bold text-lg">{{ $mkCount }}</span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Mata Kuliah</span>
                                </div>
                                <div class="w-px h-8 bg-slate-100"></div>
                                <div class="flex flex-col">
                                    <span class="text-slate-900 font-bold text-lg">{{ $enrollCount }}</span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Mahasiswa</span>
                                </div>
                                <div class="w-px h-8 bg-slate-100"></div>
                                <div class="flex flex-col">
                                    <span class="text-slate-900 font-bold text-lg">6</span>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Bulan</span>
                                </div>
                            </div>
                        </div>

                        {{-- Action --}}
                        @auth
                            @if(auth()->user()->isMahasiswa())
                                @if($isEnrolled)
                                    <div class="flex items-center justify-center gap-2 py-4 bg-slate-50 text-slate-400 rounded-2xl font-bold text-sm">
                                        <i class="fas fa-check-double"></i> Terdaftar
                                    </div>
                                @else
                                    <form method="POST" action="{{ route('programs.enroll') }}">
                                        @csrf
                                        <input type="hidden" name="prodi_id" value="{{ $p->id }}">
                                        <button type="submit" class="w-full py-4 bg-slate-800 text-white rounded-2xl font-bold text-sm shadow-xl shadow-slate-800/10 hover:bg-cyan-600 transition-all duration-300 active:scale-95">
                                            Daftar Sekarang <i class="fas fa-arrow-right ml-2 text-[10px]"></i>
                                        </button>
                                    </form>
                                @endif
                            @else
                                <div class="py-4 text-center text-slate-400 text-[11px] font-bold uppercase tracking-widest bg-slate-50 rounded-2xl">
                                    Akses Mahasiswa
                                </div>
                            @endif
                        @else
                            <a href="{{ route('register') }}" class="w-full py-4 bg-cyan-600 text-white text-center rounded-2xl font-bold text-sm shadow-xl shadow-cyan-600/10 hover:bg-cyan-700 transition-all duration-300">
                                Mulai Belajar <i class="fas fa-user-plus ml-2 text-[10px]"></i>
                            </a>
                        @endauth
                    </div>
                </div>
                @endforeach
            </div>
            {{-- Navigation --}}
            <div class="flex justify-center gap-4 mt-12">
                <button class="swiper-prev w-14 h-14 rounded-full bg-white shadow-lg flex items-center justify-center text-slate-400 hover:text-cyan-600 hover:shadow-cyan-600/10 transition group">
                    <i class="fas fa-chevron-left group-active:-translate-x-1 transition"></i>
                </button>
                <button class="swiper-next w-14 h-14 rounded-full bg-white shadow-lg flex items-center justify-center text-slate-400 hover:text-cyan-600 hover:shadow-cyan-600/10 transition group">
                    <i class="fas fa-chevron-right group-active:translate-x-1 transition"></i>
                </button>
            </div>
            <div class="swiper-pagination !static !mt-12 flex justify-center"></div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="border-t border-slate-200 py-12 text-center text-slate-400 text-sm">
        <p>&copy; 2024 Polimicro Learning Platform. Crafted with excellence.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.programsSwiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: false,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true,
            },
            navigation: {
                nextEl: '.swiper-next',
                prevEl: '.swiper-prev',
            },
            breakpoints: {
                640: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 3, spaceBetween: 30 },
            }
        });

        // Search Filter Logic
        const searchInput = document.getElementById('programSearch');
        const slides = document.querySelectorAll('.swiper-slide');

        searchInput.addEventListener('input', (e) => {
            const term = e.target.value.toLowerCase();
            let visibleCount = 0;

            slides.forEach(slide => {
                const title = slide.querySelector('h3').textContent.toLowerCase();
                const desc = slide.querySelector('p').textContent.toLowerCase();
                
                if (title.includes(term) || desc.includes(term)) {
                    slide.style.display = '';
                    visibleCount++;
                } else {
                    slide.style.display = 'none';
                }
            });

            swiper.update(); // Update swiper layout
            swiper.slideTo(0); // Reset to first slide
            
            // Handle empty state if needed
            const emptyMsg = document.getElementById('emptyState');
            if(visibleCount === 0) {
                if(!emptyMsg) {
                    const msg = document.createElement('div');
                    msg.id = 'emptyState';
                    msg.className = 'text-center py-20 text-slate-400 font-medium';
                    msg.innerHTML = '<i class="fas fa-search-minus text-4xl mb-4 block"></i> Program tidak ditemukan';
                    document.querySelector('.programsSwiper').appendChild(msg);
                }
            } else if(emptyMsg) {
                emptyMsg.remove();
            }
        });
    </script>
</body>
</html>
