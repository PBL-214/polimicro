<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Polimicro - Platform Microcredential untuk pengembangan kompetensi profesional Anda">

  <!-- Open Graph Meta Tags -->
  <meta property="og:title" content="Polimicro - Platform Microcredential">
  <meta property="og:description" content="Tingkatkan kompetensi dengan sertifikasi profesional yang diakui industri">
  <meta property="og:image" content="{{ asset('design-assets/img/og-banner.png') }}">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url('/') }}">
  <meta name="twitter:card" content="summary_large_image">

  <title>Polimicro - Platform Microcredential</title>

  <!-- Favicon -->
  <link rel="icon" href="{{ asset('design-assets/img/favicon.ico') }}" type="image/x-icon">

  <!-- Preconnect untuk CDN -->
  <link rel="preconnect" href="https://cdnjs.cloudflare.com">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <!-- Google Font: Plus Jakarta Sans -->
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="{{ asset('design-assets/css/custom.css') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    /* Typography */
    body { font-family: 'Plus Jakarta Sans', sans-serif; }

    /* Gradient text */
    .text-gradient {
      background: linear-gradient(135deg, #06b6d4 0%, #0891b2 60%, #1e293b 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* Stats section dot pattern */
    #stats-section {
      background-color: #fff;
      background-image: radial-gradient(circle, #ecfeff 1px, transparent 1px);
      background-size: 24px 24px;
    }

    /* Feature card hover lift */
    .card-modern {
      transition: transform 0.25s cubic-bezier(.34,1.56,.64,1), box-shadow 0.25s ease;
    }
    .card-modern:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 44px rgba(6, 182, 212, 0.13);
    }

    /* Program card CTA */
    .program-card {
      position: relative;
      transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .program-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 16px 40px rgba(0,0,0,0.1);
    }
    .program-card-cta {
      opacity: 0;
      transform: translateY(8px);
      transition: opacity 0.22s ease, transform 0.22s ease;
    }
    .program-card:hover .program-card-cta {
      opacity: 1;
      transform: translateY(0);
    }

    /* Tab panel fade-in transition */
    .tab-panel { display: none; }
    .tab-panel.active {
      display: block;
      animation: tabFadeIn 0.35s cubic-bezier(.4,0,.2,1) both;
    }
    @keyframes tabFadeIn {
      from { opacity: 0; transform: translateY(12px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* CTA Section */
    .cta-section {
      background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #0f172a 100%);
      position: relative;
      overflow: hidden;
    }
    .cta-section::before {
      content: ''; position: absolute; width: 700px; height: 700px;
      background: radial-gradient(circle, rgba(6, 182, 212, 0.18) 0%, transparent 65%);
      top: -250px; right: -100px; pointer-events: none;
    }
    .cta-section::after {
      content: ''; position: absolute; width: 450px; height: 450px;
      background: radial-gradient(circle, rgba(8, 145, 178, 0.12) 0%, transparent 65%);
      bottom: -120px; left: -80px; pointer-events: none;
    }

    /* Step circle with icon */
    .step-circle {
      width: 60px; height: 60px;
      background: linear-gradient(135deg, #06b6d4, #0891b2);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      color: white; font-size: 1.3rem; margin: 0 auto 1rem;
      box-shadow: 0 8px 24px rgba(6, 182, 212, 0.32);
      position: relative; z-index: 1;
    }

    /* Dramatic heading sizes */
    .section-heading { font-size: clamp(2rem, 5vw, 3rem); font-weight: 800; }

    /* Dashboard Demo Animations */
    .perspective-1000 { perspective: 1000px; }
    
    .stats-card {
      opacity: 0;
      transform: translateY(10px);
      animation: slideUpFade 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
    
    .course-card {
      opacity: 0;
      transform: translateY(10px);
      animation: slideUpFade 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
    
    .anim-delay-1 { animation-delay: 0.2s; }
    .anim-delay-2 { animation-delay: 0.4s; }
    .anim-delay-3 { animation-delay: 0.6s; }
    .anim-delay-4 { animation-delay: 0.8s; }
    
    @keyframes slideUpFade {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .progress-bar-anim {
      animation: fillProgress 1.5s cubic-bezier(0.4, 0, 0.2, 1) 1.2s forwards;
    }
    
    @keyframes fillProgress {
      from { width: 0%; }
      to { width: 65%; }
    }
    
    .float-notification {
      animation: popIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 2.5s forwards, floatUpDown 3s ease-in-out infinite 3s;
    }
    
    @keyframes popIn {
      from { opacity: 0; transform: scale(0.8) translateY(10px); }
      to { opacity: 1; transform: scale(1) translateY(0); }
    }
    
    @keyframes floatUpDown {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
    }
    
    /* Cursor Animation */
    .cursor-anim {
      top: 80%; left: 80%;
      animation: moveCursor 6s ease-in-out infinite;
    }
    
    @keyframes moveCursor {
      0% { top: 80%; left: 80%; opacity: 0; }
      10% { opacity: 1; }
      25% { top: 30%; left: 20%; transform: scale(0.9); }
      30% { transform: scale(1); } /* Click effect */
      50% { top: 50%; left: 60%; transform: scale(0.9); }
      55% { transform: scale(1); }
      75% { top: 70%; left: 85%; }
      90% { opacity: 1; }
      100% { top: 80%; left: 80%; opacity: 0; }
    }
  </style>
</head>

<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col">

  <!-- Navbar -->
  <nav id="navbar" class="fixed top-0 w-full z-50 transition-all duration-300 bg-transparent">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
      <a href="{{ route('home') }}" class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-cyan-600 flex items-center justify-center shadow-lg shadow-cyan-600/20">
          <i class="fas fa-graduation-cap text-white text-lg"></i>
        </div>
        <span class="text-2xl font-bold font-serif text-slate-800" id="logo-text">Polimicro</span>
      </a>
      <div class="hidden md:flex items-center gap-8">
        <a href="#home" class="nav-link text-slate-600 hover:text-cyan-600 font-medium transition">Beranda</a>
        <a href="#programs" class="nav-link text-slate-600 hover:text-cyan-600 font-medium transition">Program</a>
        <a href="#how" class="nav-link text-slate-600 hover:text-cyan-600 font-medium transition">Cara Kerja</a>
        <a href="{{ route('faq') }}" class="nav-link text-slate-600 hover:text-cyan-600 font-medium transition">FAQ</a>
      </div>
      <div class="hidden md:flex items-center gap-3">
        @auth
          <div class="relative group">
            <button class="flex items-center gap-2 px-3 py-2 rounded-xl border border-slate-200 hover:border-cyan-300 transition bg-white">
              <div class="w-8 h-8 rounded-full bg-cyan-100 flex items-center justify-center text-cyan-700 font-bold text-sm">
                {{ auth()->user()->getInitials() }}
              </div>
              <span class="text-sm font-medium text-slate-700 max-w-[100px] truncate">{{ auth()->user()->name }}</span>
              <i class="fas fa-chevron-down text-xs text-slate-400"></i>
            </button>
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 py-2">
              <a href="{{ route(auth()->user()->getDashboardRoute()) }}" class="block px-4 py-2 text-sm text-slate-600 hover:bg-cyan-50 hover:text-cyan-700"><i class="fas fa-th-large mr-2"></i>Dasbor Saya</a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"><i class="fas fa-sign-out-alt mr-2"></i>Keluar</button>
              </form>
            </div>
          </div>
        @else
          <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-xl text-slate-800 border border-slate-300 hover:border-cyan-600 font-medium transition">Masuk</a>
          <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-cyan-600 text-white font-semibold hover:bg-cyan-700 transition shadow-lg">Daftar</a>
        @endauth
      </div>
      <button id="mobile-menu-btn" class="md:hidden text-slate-800 text-2xl" aria-label="Toggle menu" aria-expanded="false">
        <i class="fas fa-bars"></i>
      </button>
    </div>
    <!-- Mobile menu -->
    <div id="mobile-menu" class="hidden md:hidden px-6 pb-6 bg-slate-50 border-b border-slate-200">
      <a href="#home" class="block py-3 text-slate-600 hover:text-cyan-600 font-medium border-b border-slate-100">Beranda</a>
      <a href="#programs" class="block py-3 text-slate-600 hover:text-cyan-600 font-medium border-b border-slate-100">Program</a>
      <a href="#how" class="block py-3 text-slate-600 hover:text-cyan-600 font-medium border-b border-slate-100">Cara Kerja</a>
      <a href="{{ route('faq') }}" class="block py-3 text-slate-600 hover:text-cyan-600 font-medium border-b border-slate-100">FAQ</a>
      <div class="mt-4">
        @auth
          <div class="flex flex-col gap-2">
            <a href="{{ route(auth()->user()->getDashboardRoute()) }}" class="w-full text-center py-3 rounded-xl bg-slate-100 text-slate-700 font-medium hover:bg-slate-200 transition"><i class="fas fa-th-large mr-2"></i>Dasbor Saya</a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="w-full text-center py-3 rounded-xl bg-red-50 text-red-600 font-medium hover:bg-red-100 transition"><i class="fas fa-sign-out-alt mr-2"></i>Keluar</button>
            </form>
          </div>
        @else
          <div class="flex gap-3">
            <a href="{{ route('login') }}" class="flex-1 text-center py-2.5 rounded-xl border border-slate-300 text-slate-800 font-medium">Masuk</a>
            <a href="{{ route('register') }}" class="flex-1 text-center py-2.5 rounded-xl bg-cyan-600 text-white font-semibold">Daftar</a>
          </div>
        @endauth
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section id="home" class="bg-slate-50 min-h-[100vh] flex items-center relative overflow-hidden">
    <div class="hero-blob w-[500px] h-[500px] bg-cyan-100/30 top-[-100px] right-[-100px] absolute"></div>
    <div class="hero-blob w-[350px] h-[350px] bg-slate-200/50 bottom-[10%] left-[-80px] absolute"></div>
    <div class="max-w-7xl mx-auto px-6 py-32 grid md:grid-cols-2 gap-16 items-center relative z-10">
      <div>
        <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/70 backdrop-blur border border-cyan-200 rounded-full text-cyan-800 text-sm font-semibold mb-8">
          <span class="w-2 h-2 rounded-full bg-cyan-500 animate-pulse"></span>Platform Microcredential Terpercaya di Indonesia
        </span>
        <h1 class="text-4xl md:text-[3.5rem] lg:text-[4rem] font-bold font-serif text-slate-900 leading-[1.15] mb-6 tracking-tight">
          Tingkatkan <span class="text-cyan-600">Kompetensi</span> Anda dengan Microcredential
        </h1>
        <p class="text-lg text-slate-600 mb-8 leading-relaxed max-w-lg">
          Dapatkan sertifikasi profesional melalui program terfokus yang diakui industri. Belajar fleksibel dan bangun portofolio keahlian spesifik untuk melejitkan karir Anda.
        </p>
        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-cyan-50 border border-cyan-200 rounded-lg text-cyan-700 text-sm font-medium mb-6">
          <i class="fas fa-gift"></i> Semua program tersedia <strong>GRATIS</strong> untuk mahasiswa terdaftar
        </div>
        <div class="flex flex-wrap gap-4">
          <a href="{{ route('programs') }}" class="btn-primary"><i class="fas fa-rocket"></i> Jelajahi Program</a>
          <a href="#how" class="btn-outline"><i class="fas fa-play-circle"></i> Cara Kerja Microcredential</a>
        </div>
      </div>

      <!-- Hero visual: Dashboard Demo Animation -->
      <div class="hidden md:block relative w-full h-[500px] perspective-1000 pl-8 group">
        <!-- Abstract background elements -->
        <div class="absolute inset-0 bg-gradient-to-br from-cyan-200/40 to-blue-200/20 rounded-[2.5rem] transform rotate-2 scale-105 ml-8 transition-all duration-500 group-hover:-translate-y-3 group-hover:scale-105 group-hover:rotate-2 group-hover:shadow-xl"></div>
        
        <!-- Browser Mockup -->
        <div class="absolute inset-0 bg-white rounded-2xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.15)] border border-slate-200 overflow-hidden flex flex-col transform transition-all duration-500 z-10 ml-8 group-hover:-translate-y-3 group-hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.2)]">
          <!-- Browser Header -->
          <div class="h-10 bg-slate-50 border-b border-slate-200 flex items-center px-4 gap-2">
            <div class="flex gap-1.5">
              <div class="w-3 h-3 rounded-full bg-red-400"></div>
              <div class="w-3 h-3 rounded-full bg-amber-400"></div>
              <div class="w-3 h-3 rounded-full bg-green-400"></div>
            </div>
            <div class="mx-auto px-4 py-1.5 bg-white rounded-md text-[10px] text-slate-400 border border-slate-200 shadow-sm font-medium w-1/2 flex items-center justify-center gap-2">
              <i class="fas fa-lock text-[8px] text-slate-400"></i> polimicro.ac.id/dashboard
            </div>
          </div>
          
          <!-- Dashboard Body -->
          <div class="flex-1 flex bg-slate-50 relative overflow-hidden">
            <!-- Sidebar -->
            <div class="w-16 lg:w-44 bg-white border-r border-slate-200 p-4 flex flex-col gap-4">
              <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 rounded-lg bg-cyan-600 flex-shrink-0 flex items-center justify-center"><i class="fas fa-graduation-cap text-white text-xs"></i></div>
                <div class="h-3 bg-slate-200 rounded w-20 hidden lg:block"></div>
              </div>
              
              <div class="flex items-center gap-3 p-2.5 rounded-lg bg-cyan-50 text-cyan-600">
                <i class="fas fa-th-large w-5 text-center text-sm"></i>
                <div class="h-2.5 bg-cyan-200 rounded w-16 hidden lg:block"></div>
              </div>
              <div class="flex items-center gap-3 p-2.5 rounded-lg text-slate-400">
                <i class="fas fa-book w-5 text-center text-sm"></i>
                <div class="h-2.5 bg-slate-200 rounded w-20 hidden lg:block"></div>
              </div>
              <div class="flex items-center gap-3 p-2.5 rounded-lg text-slate-400">
                <i class="fas fa-award w-5 text-center text-sm"></i>
                <div class="h-2.5 bg-slate-200 rounded w-16 hidden lg:block"></div>
              </div>
              
              <div class="mt-auto flex items-center gap-3 p-2.5 rounded-lg text-slate-400">
                <div class="w-7 h-7 rounded-full bg-slate-200 flex-shrink-0"></div>
                <div class="h-2.5 bg-slate-200 rounded w-16 hidden lg:block"></div>
              </div>
            </div>
            
            <!-- Main Content -->
            <div class="flex-1 p-5 flex flex-col gap-5 relative">
              <!-- Header -->
              <div class="flex justify-between items-end">
                <div>
                  <div class="h-4 bg-slate-800 rounded w-32 mb-2"></div>
                  <div class="h-2.5 bg-slate-400 rounded w-48"></div>
                </div>
                <div class="px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-[10px] font-bold text-slate-600 flex items-center gap-2">
                   <i class="fas fa-calendar-alt text-cyan-600"></i> Semester Ganjil
                </div>
              </div>
              
              <!-- Stats Row -->
              <div class="grid grid-cols-3 gap-3">
                <div class="bg-white p-3 rounded-xl shadow-sm border border-slate-100 stats-card anim-delay-1 flex flex-col justify-between">
                  <div class="h-2.5 bg-slate-300 rounded w-16 mb-2"></div>
                  <div class="flex items-end gap-2">
                    <div class="h-6 bg-cyan-600 rounded w-8"></div>
                    <div class="h-2 bg-green-200 rounded w-10 mb-1"></div>
                  </div>
                </div>
                <div class="bg-white p-3 rounded-xl shadow-sm border border-slate-100 stats-card anim-delay-2 flex flex-col justify-between">
                  <div class="h-2.5 bg-slate-300 rounded w-20 mb-2"></div>
                  <div class="flex items-end gap-2">
                    <div class="h-6 bg-slate-700 rounded w-12"></div>
                  </div>
                </div>
                <div class="bg-white p-3 rounded-xl shadow-sm border border-slate-100 stats-card anim-delay-3 flex flex-col justify-between">
                  <div class="h-2.5 bg-slate-300 rounded w-14 mb-2"></div>
                  <div class="flex items-end gap-2">
                    <div class="h-6 bg-orange-500 rounded w-6"></div>
                  </div>
                </div>
              </div>
              
              <!-- Active Course -->
              <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 flex-1 relative course-card anim-delay-4 flex flex-col">
                <div class="flex justify-between items-center mb-4">
                   <div class="h-3 bg-slate-800 rounded w-32"></div>
                   <div class="w-5 h-5 rounded bg-slate-100 flex items-center justify-center"><i class="fas fa-ellipsis-h text-[10px] text-slate-400"></i></div>
                </div>
                
                <div class="flex gap-4 items-center mb-4">
                  <div class="w-12 h-12 rounded-lg bg-cyan-50 flex-shrink-0 flex items-center justify-center border border-cyan-100">
                    <i class="fas fa-laptop-code text-cyan-600 text-lg"></i>
                  </div>
                  <div class="flex-1 space-y-2">
                    <div class="h-3 bg-slate-800 rounded w-3/4"></div>
                    <div class="h-2.5 bg-slate-400 rounded w-1/2"></div>
                  </div>
                </div>
                
                <div class="mt-auto">
                  <div class="flex justify-between text-[10px] font-bold text-slate-500 mb-1.5">
                    <span>Progress Pembelajaran</span>
                    <span class="text-cyan-600">65%</span>
                  </div>
                  <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-cyan-500 rounded-full progress-bar-anim" style="width: 0%"></div>
                  </div>
                </div>
                
                <!-- Floating Notification -->
                <div class="absolute -right-6 -bottom-6 bg-white p-3 rounded-xl shadow-[0_10px_25px_rgba(0,0,0,0.1)] border border-slate-100 flex items-center gap-3 float-notification opacity-0 z-20">
                  <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                    <i class="fas fa-check text-xs"></i>
                  </div>
                  <div>
                    <div class="text-xs font-bold text-slate-800">Tugas Dinilai</div>
                    <div class="text-[10px] text-slate-500">Selamat! Anda dapat 95</div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Animated cursor -->
            <div class="absolute w-5 h-5 cursor-anim z-50 pointer-events-none drop-shadow-md">
              <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.5 3.21V20.8C5.5 21.45 6.27 21.78 6.74 21.34L11.45 16.92C11.64 16.74 11.89 16.64 12.15 16.64H18.78C19.46 16.64 19.8 15.82 19.32 15.34L6.71 2.73C6.23 2.25 5.5 2.59 5.5 3.21Z" fill="#1e293b" stroke="white" stroke-width="1.5"/>
              </svg>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Partners -->
  <section class="py-14 section-cream">
    <div class="max-w-7xl mx-auto px-6">
      <p class="text-center text-sm font-semibold text-[slate-500] uppercase tracking-wider mb-8">Sertifikat Dipercaya oleh Industri</p>
      <div class="marquee-container">
        <div class="marquee-track">
          <span class="partner-wordmark">Universitas Indonesia</span>
          <span class="partner-wordmark"><span class="pw-dot" style="background:#e41e26"></span>Telkom Indonesia</span>
          <span class="partner-wordmark" style="color:#2baa4e">Tokopedia</span>
          <span class="partner-wordmark">Institut Teknologi Bandung</span>
          <span class="partner-wordmark" style="color:#00aa5b">Gojek</span>
          <span class="partner-wordmark"><span class="pw-dot" style="background:#e3292b"></span>Bukalapak</span>
          <span class="partner-wordmark">Samsung R&D</span>
          <span class="partner-wordmark"><span class="pw-dot" style="background:#0054a6"></span>BSSN</span>
          <!-- Duplicate for seamless loop -->
          <span class="partner-wordmark">Universitas Indonesia</span>
          <span class="partner-wordmark"><span class="pw-dot" style="background:#e41e26"></span>Telkom Indonesia</span>
          <span class="partner-wordmark" style="color:#2baa4e">Tokopedia</span>
          <span class="partner-wordmark">Institut Teknologi Bandung</span>
          <span class="partner-wordmark" style="color:#00aa5b">Gojek</span>
          <span class="partner-wordmark"><span class="pw-dot" style="background:#e3292b"></span>Bukalapak</span>
          <span class="partner-wordmark">Samsung R&D</span>
          <span class="partner-wordmark"><span class="pw-dot" style="background:#0054a6"></span>BSSN</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Statistics -->
  <section id="stats-section" class="py-20">
    <div class="max-w-5xl mx-auto px-6">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div class="stat-block scroll-reveal stagger-1">
          <div class="w-12 h-12 mx-auto rounded-xl bg-cyan-50 flex items-center justify-center mb-3">
            <i class="fas fa-user-graduate text-cyan-700 text-lg"></i>
          </div>
          <div class="stat-number" data-target="500">0</div>
          <div class="stat-label">Mahasiswa Aktif</div>
        </div>
        <div class="stat-block scroll-reveal stagger-2">
          <div class="w-12 h-12 mx-auto rounded-xl bg-blue-50 flex items-center justify-center mb-3">
            <i class="fas fa-book-open text-blue-700 text-lg"></i>
          </div>
          <div class="stat-number" data-target="50">0</div>
          <div class="stat-label">Program Microcredential</div>
        </div>
        <div class="stat-block scroll-reveal stagger-3">
          <div class="w-12 h-12 mx-auto rounded-xl bg-orange-50 flex items-center justify-center mb-3">
            <i class="fas fa-certificate text-orange-600 text-lg"></i>
          </div>
          <div class="stat-number" data-target="1200">0</div>
          <div class="stat-label">Sertifikat Terbit</div>
        </div>
        <div class="stat-block scroll-reveal stagger-4">
          <div class="w-12 h-12 mx-auto rounded-xl bg-purple-50 flex items-center justify-center mb-3">
            <i class="fas fa-handshake text-purple-700 text-lg"></i>
          </div>
          <div class="stat-number" data-target="30">0</div>
          <div class="stat-label">Mitra Industri</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Programs -->
  <section id="programs" class="py-24 section-cream">
    <div class="max-w-7xl mx-auto px-6">
      <div class="text-center mb-16">
        <span class="inline-block px-4 py-2 bg-cyan-100 text-cyan-700 rounded-full text-sm font-semibold mb-4">Program Unggulan</span>
        <h2 class="section-heading text-gray-900 mb-4">Pilih Jalur Keahlian Anda</h2>
        <p class="text-gray-500 text-lg max-w-2xl mx-auto">Kami merancang program microcredential yang sangat spesifik dan aplikatif, sesuai dengan kebutuhan riil di dunia kerja digital saat ini.</p>
      </div>
      
      <div id="programs-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Akan diisi oleh JS jika ada API, fallback hardcoded jika tidak -->
        <div class="program-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
          <div class="flex items-start justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl bg-cyan-100 flex items-center justify-center text-2xl">🤖</div>
            <span class="text-xs font-semibold px-2.5 py-1 bg-cyan-50 text-cyan-700 rounded-full">Teknologi</span>
          </div>
          <h3 class="font-bold text-lg mb-2">Artificial Intelligence</h3>
          <p class="text-gray-500 text-sm mb-4 line-clamp-3">Program studi microcredential yang berfokus pada pengembangan kecerdasan buatan, machine learning, dan deep learning.</p>
          <div class="flex items-center justify-between text-sm mb-4">
            <span class="text-cyan-600 font-medium"><i class="fas fa-clock mr-1"></i>6 Bulan</span>
          </div>
          <a href="{{ route('programs') }}" class="program-card-cta block w-full text-center py-2.5 rounded-xl bg-cyan-700 text-white text-sm font-semibold hover:bg-cyan-800 transition">
            Lihat Detail <i class="fas fa-arrow-right ml-1 text-xs"></i>
          </a>
        </div>
        <div class="program-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
          <div class="flex items-start justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">📊</div>
            <span class="text-xs font-semibold px-2.5 py-1 bg-blue-50 text-blue-700 rounded-full">Data</span>
          </div>
          <h3 class="font-bold text-lg mb-2">Data Science & Analytics</h3>
          <p class="text-gray-500 text-sm mb-4 line-clamp-3">Kuasai analisis big data, statistik, dan visualisasi data untuk pengambilan keputusan bisnis strategis.</p>
          <div class="flex items-center justify-between text-sm mb-4">
            <span class="text-cyan-600 font-medium"><i class="fas fa-clock mr-1"></i>6 Bulan</span>
          </div>
          <a href="{{ route('programs') }}" class="program-card-cta block w-full text-center py-2.5 rounded-xl bg-cyan-700 text-white text-sm font-semibold hover:bg-cyan-800 transition">
            Lihat Detail <i class="fas fa-arrow-right ml-1 text-xs"></i>
          </a>
        </div>
        <div class="program-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
          <div class="flex items-start justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center text-2xl">🔒</div>
            <span class="text-xs font-semibold px-2.5 py-1 bg-orange-50 text-orange-700 rounded-full">Keamanan</span>
          </div>
          <h3 class="font-bold text-lg mb-2">Cybersecurity</h3>
          <p class="text-gray-500 text-sm mb-4 line-clamp-3">Pelajari keamanan jaringan, ethical hacking, dan manajemen risiko keamanan informasi tingkat lanjut.</p>
          <div class="flex items-center justify-between text-sm mb-4">
            <span class="text-cyan-600 font-medium"><i class="fas fa-clock mr-1"></i>4 Bulan</span>
          </div>
          <a href="{{ route('programs') }}" class="program-card-cta block w-full text-center py-2.5 rounded-xl bg-cyan-700 text-white text-sm font-semibold hover:bg-cyan-800 transition">
            Lihat Detail <i class="fas fa-arrow-right ml-1 text-xs"></i>
          </a>
        </div>
        <div class="program-card bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
          <div class="flex items-start justify-between mb-4">
            <div class="w-14 h-14 rounded-2xl bg-purple-100 flex items-center justify-center text-2xl">🎨</div>
            <span class="text-xs font-semibold px-2.5 py-1 bg-purple-50 text-purple-700 rounded-full">Desain</span>
          </div>
          <h3 class="font-bold text-lg mb-2">UI/UX Design</h3>
          <p class="text-gray-500 text-sm mb-4 line-clamp-3">Kuasai seni mendesain antarmuka pengguna yang intuitif dan menciptakan pengalaman digital yang luar biasa.</p>
          <div class="flex items-center justify-between text-sm mb-4">
            <span class="text-cyan-600 font-medium"><i class="fas fa-clock mr-1"></i>4 Bulan</span>
          </div>
          <a href="{{ route('programs') }}" class="program-card-cta block w-full text-center py-2.5 rounded-xl bg-cyan-700 text-white text-sm font-semibold hover:bg-cyan-800 transition">
            Lihat Detail <i class="fas fa-arrow-right ml-1 text-xs"></i>
          </a>
        </div>
      </div>
      
      <div class="text-center mt-12">
        <a href="{{ route('programs') }}"
          class="inline-flex items-center gap-2 px-8 py-4 btn-primary text-white rounded-2xl font-semibold text-lg">
          Lihat Semua Program Microcredential <i class="fas fa-arrow-right"></i>
        </a>
      </div>
    </div>
  </section>

  <!-- How it Works -->
  <section id="how" class="py-24 section-white">
    <div class="max-w-5xl mx-auto px-6">
      <div class="text-center mb-16 scroll-reveal">
        <span class="inline-block px-4 py-2 bg-cyan-50 text-cyan-700 rounded-full text-sm font-semibold mb-4">Alur Microcredential</span>
        <h2 class="section-heading text-[slate-900] mb-4">Cara Kerja Program Ini</h2>
        <p class="text-[slate-500] text-lg">Sistem kami fokus pada pembuktian skill, bukan sekadar durasi belajar.</p>
        <div class="section-title-line"></div>
      </div>
      <div class="steps-container scroll-reveal">
        <div class="step-item">
          <div class="step-circle"><i class="fas fa-laptop-code"></i></div>
          <div class="step-connector"></div>
          <h3 class="text-lg font-bold text-[slate-900] mb-2">1. Pelajari Modul</h3>
          <p class="text-[slate-500] text-sm">Akses materi spesifik, best practice industri, dan kerjakan studi kasus nyata.</p>
        </div>
        <div class="step-item">
          <div class="step-circle"><i class="fas fa-project-diagram"></i></div>
          <div class="step-connector"></div>
          <h3 class="text-lg font-bold text-[slate-900] mb-2">2. Selesaikan Proyek</h3>
          <p class="text-[slate-500] text-sm">Buktikan kompetensi Anda melalui tugas proyek yang akan direview langsung oleh expert.</p>
        </div>
        <div class="step-item">
          <div class="step-circle"><i class="fas fa-medal"></i></div>
          <h3 class="text-lg font-bold text-[slate-900] mb-2">3. Dapatkan Badge & Sertifikat</h3>
          <p class="text-[slate-500] text-sm">Klaim micro-sertifikat Anda sebagai bukti sah kepemilikan skill di mata recruiter.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="cta-section py-28">
    <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
      <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 border border-white/20 rounded-full text-cyan-300 text-sm font-semibold mb-6">
        <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>Pendaftaran Batch Baru Dibuka
      </span>
      <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-6 leading-tight">
        Siap Membangun<br>Portofolio Skill Anda?
      </h2>
      <p class="text-cyan-200/80 text-lg mb-10 max-w-2xl mx-auto leading-relaxed">
        Bergabung bersama 500+ profesional yang sudah mempercepat karir mereka melalui program microcredential Polimicro.
      </p>
      <div class="flex flex-wrap gap-4 justify-center">
        <a href="{{ route('register') }}"
          class="px-8 py-4 rounded-2xl bg-white text-slate-800 font-bold text-lg hover:bg-cyan-50 transition shadow-2xl inline-flex items-center gap-2">
          <i class="fas fa-rocket"></i>Mulai Secara Gratis
        </a>
        <a href="{{ route('programs') }}"
          class="px-8 py-4 rounded-2xl border-2 border-white/30 text-white font-semibold text-lg hover:bg-white/10 transition inline-flex items-center gap-2">
          <i class="fas fa-search"></i>Lihat Katalog Program
        </a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer-section text-white py-16 mt-auto">
    <div class="max-w-7xl mx-auto px-6">
      <div class="grid md:grid-cols-4 gap-10">
        <div>
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
              <i class="fas fa-graduation-cap text-lg"></i>
            </div>
            <span class="text-xl font-bold">Polimicro</span>
          </div>
          <p class="text-cyan-200 text-sm leading-relaxed">Platform microcredential terdepan untuk pengembangan kompetensi teknis dan profesional yang spesifik.</p>
        </div>
        <div>
          <h4 class="font-semibold mb-4">Menu</h4>
          <div class="space-y-2 text-sm text-cyan-200">
            <a href="#home" class="block hover:text-white transition">Beranda</a>
            <a href="#programs" class="block hover:text-white transition">Program</a>
            <a href="#how" class="block hover:text-white transition">Cara Kerja</a>
          </div>
        </div>
        <div>
          <h4 class="font-semibold mb-4">Akun</h4>
          <div class="space-y-2 text-sm text-cyan-200">
            <a href="{{ route('login') }}" class="block hover:text-white transition">Masuk</a>
            <a href="{{ route('register') }}" class="block hover:text-white transition">Daftar</a>
          </div>
        </div>
        <div>
          <h4 class="font-semibold mb-4">Kontak</h4>
          <div class="space-y-2 text-sm text-cyan-200">
            <p><i class="fas fa-envelope mr-2"></i>info@polimicro.ac.id</p>
            <p><i class="fas fa-phone mr-2"></i>(021) 1234-5678</p>
          </div>
        </div>
      </div>
      <div class="border-t border-white/15 mt-10 pt-6 text-center text-sm text-cyan-200">
        &copy; <span id="footer-year"></span> Polimicro. All rights reserved.
      </div>
    </div>
  </footer>

  <script>
    document.getElementById('footer-year').textContent = new Date().getFullYear();

    // Navbar scroll
    window.addEventListener('scroll', () => {
      const nav = document.getElementById('navbar');
      nav.classList.toggle('nav-scrolled', window.scrollY > 50);
    });

    // Mobile menu
    const mobileBtn = document.getElementById('mobile-menu-btn');
    mobileBtn.addEventListener('click', () => {
      const menu = document.getElementById('mobile-menu');
      menu.classList.toggle('hidden');
    });

    // Scroll Reveal
    const revealObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('revealed');
          revealObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15 });

    document.querySelectorAll('.scroll-reveal, .scroll-reveal-left, .scroll-reveal-right')
      .forEach(el => revealObserver.observe(el));

    // Stats Counter
    let counterStarted = false;
    const counterObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting && !counterStarted) {
          counterStarted = true;
          document.querySelectorAll('.stat-number[data-target]').forEach(counter => {
            const target = parseInt(counter.dataset.target);
            const step = target / (2000 / 16);
            let current = 0;
            const timer = setInterval(() => {
              current = Math.min(current + step, target);
              counter.textContent = Math.floor(current).toLocaleString('id-ID') + '+';
              if (current >= target) clearInterval(timer);
            }, 16);
          });
        }
      });
    }, { threshold: 0.3 });

    const statsSection = document.querySelector('#stats-section');
    if (statsSection) counterObserver.observe(statsSection);

    // Progress bar animation for the new course card
    setTimeout(() => {
        const progs = document.querySelectorAll('.progress-bar-anim');
        progs.forEach(prog => {
            prog.style.width = '0%';
            setTimeout(() => {
                prog.style.transition = 'width 1.5s cubic-bezier(0.4, 0, 0.2, 1)';
                prog.style.width = '65%';
            }, 1200);
        });
    }, 100);
    
    // Progress bar animation
    setTimeout(() => {
        const prog = document.querySelector('.anim-progress');
        if(prog) {
            prog.style.width = '0%';
            setTimeout(() => {
                prog.style.transition = 'width 1.5s ease-out';
                prog.style.width = '60%';
            }, 500);
        }
    }, 1000);
  </script>
</body>
</html>
