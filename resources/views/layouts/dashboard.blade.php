<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <title>@yield('title', 'Polimicro')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <link rel="stylesheet" href="{{ asset('design-assets/css/custom.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" />
    @stack('styles')
    <style>
        .empty-state-card { background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: 2px dashed #e2e8f0; }
        .empty-state-icon { background: white; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); }
        
        /* Global Progress Bar */
        #top-progress { position: fixed; top: 0; left: 0; height: 3px; background: linear-gradient(to right, #06b6d4, #3b82f6); z-index: 9999; width: 0; transition: width 0.4s ease, opacity 0.4s ease; }

        /* Table Actions */
        .row-actions { opacity: 1; transform: none; pointer-events: auto; }
        
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }

        /* Mobile Optimization: Prevent iOS Auto-Zoom on Focus */
        @media screen and (max-width: 768px) {
            input, select, textarea { font-size: 16px !important; }
        }

        /* Dark Mode Transition Elements */
        body, nav, div, p, span, h1, h2, h3, h4, h5, h6, a, button, input, textarea, select {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }

        /* Dark Mode Switch Animation */
        #dark-mode-icon {
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
        }
        .rotate-in {
            transform: rotate(360deg) scale(1.2);
            opacity: 0;
        }

        /* Auto Dark Mode Overrides (Global) */
        .dark .bg-white { background-color: #1e293b !important; border-color: #334155 !important; }
        .dark .text-gray-900, .dark .text-slate-900, .dark .text-slate-800 { color: #f8fafc !important; }
        .dark .text-gray-700, .dark .text-slate-700, .dark .text-gray-600, .dark .text-slate-600 { color: #cbd5e1 !important; }
        .dark .text-gray-500, .dark .text-slate-500, .dark .text-slate-400 { color: #94a3b8 !important; }
        .dark .bg-slate-50, .dark .bg-gray-50 { background-color: #0f172a !important; border-color: #334155 !important; }
        .dark .bg-slate-50\/50, .dark .bg-gray-50\/50 { background-color: rgba(15, 23, 42, 0.5) !important; }
        .dark .bg-cyan-50, .dark .bg-blue-50, .dark .bg-emerald-50, .dark .bg-yellow-50, .dark .bg-red-50, .dark .bg-amber-50, .dark .bg-purple-50 { background-color: rgba(15, 23, 42, 0.8) !important; border-color: #334155 !important; }
        .dark .bg-cyan-100, .dark .bg-blue-100 { background-color: #1e293b !important; }
        .dark .bg-cyan-50\/20 { background-color: rgba(8, 145, 178, 0.05) !important; }
        .dark .bg-cyan-50\/50 { background-color: rgba(8, 145, 178, 0.1) !important; }
        .dark .border-cyan-100, .dark .border-blue-100, .dark .border-emerald-100, .dark .border-yellow-100, .dark .border-red-100, .dark .border-amber-100, .dark .border-purple-100 { border-color: #334155 !important; }
        .dark .border-gray-100, .dark .border-slate-100, .dark .border-slate-200, .dark .border-gray-200, .dark .border-gray-50, .dark .border-b, .dark .border-t { border-color: #334155 !important; }
        .dark .bg-slate-100, .dark .bg-gray-100 { background-color: #334155 !important; }
        .dark .divide-gray-50 > :not([hidden]) ~ :not([hidden]), .dark .divide-slate-50 > :not([hidden]) ~ :not([hidden]), .dark .divide-gray-100 > :not([hidden]) ~ :not([hidden]), .dark .divide-slate-100 > :not([hidden]) ~ :not([hidden]) { border-color: #334155 !important; }
        
        /* Form Inputs */
        .dark input[type="text"], .dark input[type="email"], .dark input[type="password"], .dark input[type="number"], .dark input[type="date"], .dark input[type="datetime-local"], .dark input[type="time"], .dark textarea, .dark select { background-color: #0f172a !important; border-color: #334155 !important; color: #f8fafc !important; }
        .dark input::placeholder, .dark textarea::placeholder { color: #64748b !important; }
        .dark input[type="file"]::file-selector-button { background-color: #334155 !important; color: #f8fafc !important; border-color: #475569 !important; }
        .dark input[type="file"]:hover::file-selector-button { background-color: #475569 !important; }
        
        /* FullCalendar Enhancements */
        .dark .fc-theme-standard td, .dark .fc-theme-standard th { border-color: #334155 !important; }
        .dark .fc-header-toolbar { border-bottom-color: #334155 !important; }
        .dark .fc-day-today { background-color: #334155 !important; }
        .dark .fc-daygrid-day-number, .dark .fc-col-header-cell-cushion { color: #cbd5e1 !important; }
        .dark .fc .fc-button-primary { background-color: #334155 !important; border-color: #475569 !important; color: #f8fafc !important; }
        .dark .fc .fc-button-primary:hover { background-color: #475569 !important; }
        .dark .fc .fc-button-primary:not(:disabled):active, .dark .fc .fc-button-primary:not(:disabled).fc-button-active { background-color: #1e293b !important; border-color: #0ea5e9 !important; }
        .dark .fc-toolbar-title { color: #f8fafc !important; }
        
        /* Table Enhancements */
        .dark table th { background-color: #0f172a !important; color: #94a3b8 !important; border-bottom-color: #334155 !important; }
        .dark table td { border-bottom-color: #334155 !important; color: #cbd5e1 !important; }
        .dark table tbody tr:hover { background-color: #334155 !important; }
        .dark table tbody tr.bg-gray-50, .dark table tbody tr.bg-slate-50 { background-color: #0f172a !important; }
        
        /* Modals and Dropdowns in dark mode */
        .dark #search-results, .dark .absolute.bg-white { background-color: #1e293b !important; border-color: #334155 !important; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-700 dark:text-slate-300">
    <div id="top-progress"></div>
    @php
        $user = auth()->user();
        $role = $user->role;
        $initials = $user->getInitials();
        $activePage = $activePage ?? '';

        $menus = [
            'mahasiswa' => [
                'MAIN' => [
                    ['label' => 'Dashboard', 'icon' => 'fas fa-th-large', 'route' => 'mahasiswa.dashboard', 'id' => 'dashboard'],
                ],
                'LEARNING' => [
                    ['label' => 'Mata Kuliah Saya', 'icon' => 'fas fa-book-open', 'route' => 'mahasiswa.courses', 'id' => 'courses'],
                ],
                'RESULTS' => [
                    ['label' => 'Nilai', 'icon' => 'fas fa-chart-bar', 'route' => 'mahasiswa.grades', 'id' => 'grades'],
                    ['label' => 'Sertifikat', 'icon' => 'fas fa-certificate', 'route' => 'mahasiswa.certificates', 'id' => 'certificates'],
                ]
            ],
            'dosen' => [
                'MAIN' => [
                    ['label' => 'Dashboard', 'icon' => 'fas fa-th-large', 'route' => 'dosen.dashboard', 'id' => 'dashboard'],
                ],
                'MANAGEMENT' => [
                    ['label' => 'Matkul Saya', 'icon' => 'fas fa-book-open', 'route' => 'dosen.courses', 'id' => 'courses'],
                ],
                'ACTIVITY' => [
                    ['label' => 'Pengumpulan', 'icon' => 'fas fa-inbox', 'route' => 'dosen.submissions', 'id' => 'submissions'],
                    ['label' => 'Mahasiswa', 'icon' => 'fas fa-users', 'route' => 'dosen.students', 'id' => 'students'],
                ]
            ],
            'admin_pic' => [
                'MAIN' => [
                    ['label' => 'Dashboard', 'icon' => 'fas fa-th-large', 'route' => 'admin-pic.dashboard', 'id' => 'dashboard'],
                ],
                'OPERATIONAL' => [
                    ['label' => 'Verifikasi', 'icon' => 'fas fa-user-check', 'route' => 'admin-pic.verification', 'id' => 'verification'],
                ],
                'DATA' => [
                    ['label' => 'Mata Kuliah', 'icon' => 'fas fa-book', 'route' => 'admin-pic.courses', 'id' => 'courses'],
                    ['label' => 'Data Pelajar', 'icon' => 'fas fa-user-graduate', 'route' => 'admin-pic.students', 'id' => 'students'],
                ]
            ],
            'admin_akademik' => [
                'MAIN' => [
                    ['label' => 'Dashboard', 'icon' => 'fas fa-th-large', 'route' => 'admin-akademik.dashboard', 'id' => 'dashboard'],
                ],
                'MANAGEMENT' => [
                    ['label' => 'Data Dosen', 'icon' => 'fas fa-chalkboard-teacher', 'route' => 'admin-akademik.lecturers', 'id' => 'lecturers'],
                    ['label' => 'Program Studi', 'icon' => 'fas fa-university', 'route' => 'admin-akademik.programs', 'id' => 'programs'],
                ],
                'RECORDS' => [
                    ['label' => 'Sertifikat', 'icon' => 'fas fa-certificate', 'route' => 'admin-akademik.certificates', 'id' => 'certificates'],
                    ['label' => 'Laporan', 'icon' => 'fas fa-chart-line', 'route' => 'admin-akademik.reports', 'id' => 'reports'],
                ]
            ],
        ];
        $itemsByGroup = $menus[$role] ?? [];
    @endphp

    {{-- Top Navbar --}}
    <nav class="bg-slate-800 text-white shadow-xl fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <div class="flex items-center flex-shrink-0 w-48">
                    <a href="{{ route('programs') }}" class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-cyan-500 flex items-center justify-center shadow-lg shadow-cyan-500/20"><i class="fas fa-graduation-cap text-sm text-white"></i></div>
                        <span class="text-xl font-bold font-serif tracking-tight text-white hidden sm:block">Polimicro</span>
                    </a>
                </div>
                    
                {{-- Center Desktop Navigation --}}
                <div class="hidden xl:flex flex-1 justify-center items-center gap-2">
                    @foreach($itemsByGroup as $group => $items)
                        @foreach($items as $item)
                            <a href="{{ route($item['route']) }}" onclick="startProgress()" class="px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-all {{ $activePage === $item['id'] ? 'bg-cyan-500 text-white shadow-md shadow-cyan-500/20' : 'text-slate-300 hover:text-white hover:bg-slate-700' }}">
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    @endforeach
                </div>

                {{-- User & Notifications --}}
                <div class="flex items-center gap-4">
                    
                    {{-- Global Search --}}
                    <div class="relative hidden md:block">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-slate-400 text-sm"></i>
                        </div>
                        <input type="text" id="global-search" placeholder="Cari sesuatu..." class="bg-slate-700 text-sm text-white rounded-full pl-9 pr-4 py-1.5 focus:outline-none focus:ring-2 focus:ring-cyan-500 placeholder-slate-400 w-48 transition-all duration-300 focus:w-64">
                        <div id="search-results" class="absolute top-full mt-2 w-full bg-white rounded-xl shadow-xl overflow-hidden hidden flex-col border border-slate-100 z-50"></div>
                    </div>

                    {{-- Dark Mode Toggle --}}
                    <button id="dark-mode-toggle" class="text-slate-300 hover:text-white transition p-2 focus:outline-none">
                        <i class="fas fa-moon text-lg" id="dark-mode-icon"></i>
                    </button>

                    {{-- Notification Center --}}
                    <div class="relative group">
                        <button class="relative text-slate-300 hover:text-white transition p-2">
                            <i class="fas fa-bell text-lg"></i>
                            @if($unreadCount > 0)
                                <span class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full border-2 border-slate-800 flex items-center justify-center">{{ $unreadCount }}</span>
                            @endif
                        </button>
                        <div class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 overflow-hidden text-slate-700 border border-slate-100">
                            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                                <h4 class="font-bold text-sm">Notifikasi</h4>
                                @if($unreadCount > 0)
                                    <form method="POST" action="{{ route('notifications.markAllRead') }}">
                                        @csrf
                                        <button type="submit" class="text-[10px] text-cyan-600 font-semibold hover:underline">Tandai semua dibaca</button>
                                    </form>
                                @endif
                            </div>
                            <div class="max-h-[350px] overflow-y-auto">
                                @forelse($notifications as $notif)
                                    <a href="{{ route('notifications.click', $notif->id) }}" class="p-4 hover:bg-cyan-50/50 transition border-b border-gray-50 flex gap-3 block">
                                        <div class="w-8 h-8 rounded-full {{ $notif->data['color'] ?? 'bg-cyan-100' }} flex items-center justify-center {{ $notif->data['text_color'] ?? 'text-cyan-600' }} flex-shrink-0">
                                            <i class="{{ $notif->data['icon'] ?? 'fas fa-bell' }} text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-slate-800">{{ $notif->data['title'] ?? 'Notifikasi Baru' }}</p>
                                            <p class="text-[10px] text-gray-500 leading-tight mt-0.5">{{ $notif->data['message'] ?? '' }}</p>
                                            <p class="text-[9px] text-cyan-500 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                                        </div>
                                    </a>
                                @empty
                                    <div class="p-8 text-center">
                                        <i class="fas fa-bell-slash text-gray-200 text-3xl mb-2"></i>
                                        <p class="text-xs text-gray-400">Tidak ada notifikasi baru</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    
                    {{-- Profile Menu Desktop --}}
                    <div class="hidden lg:flex items-center gap-3 border-l border-slate-700 pl-4">

                        <a href="{{ Route::has($role . '.profile') ? route($role . '.profile') : '#' }}" class="w-9 h-9 rounded-full overflow-hidden flex items-center justify-center text-white text-sm font-bold shadow-lg shadow-cyan-500/20 hover:scale-110 transition cursor-pointer" style="background:linear-gradient(135deg,#0ea5e9,#06b6d4)" title="Lihat Profil">
                            @if($user->avatar)
                                <img src="{{ $user->getAvatarUrl() }}" class="w-full h-full object-cover">
                            @else
                                {{ $initials }}
                            @endif
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="ml-2">
                            @csrf
                            <button type="submit" class="text-slate-400 hover:text-red-400 transition" title="Keluar"><i class="fas fa-sign-out-alt"></i></button>
                        </form>
                    </div>

                    {{-- Mobile menu button --}}
                    <div class="lg:hidden flex items-center">
                        <button onclick="toggleMobileMenu()" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-700 focus:outline-none transition">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mobile Navigation Menu --}}
        <div id="mobile-menu" class="lg:hidden hidden bg-slate-900 border-t border-slate-700">
            <div class="px-4 py-4 space-y-1 overflow-y-auto max-h-[80vh]">
                <a href="{{ Route::has($role . '.profile') ? route($role . '.profile') : '#' }}" class="flex items-center gap-3 mb-6 p-3 bg-slate-800 rounded-xl hover:bg-slate-700 transition cursor-pointer">
                    <div class="w-10 h-10 rounded-full overflow-hidden flex items-center justify-center text-white text-sm font-bold bg-cyan-600 shadow-lg">
                        @if($user->avatar)
                            <img src="{{ $user->getAvatarUrl() }}" class="w-full h-full object-cover">
                        @else
                            {{ $initials }}
                        @endif
                    </div>

                </a>

                @foreach($itemsByGroup as $group => $items)
                    <div class="px-3 py-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-2">{{ $group }}</div>
                    @foreach($items as $item)
                        <a href="{{ route($item['route']) }}" class="flex items-center px-3 py-3 rounded-xl text-sm font-medium transition {{ $activePage === $item['id'] ? 'bg-cyan-500 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <i class="{{ $item['icon'] }} w-6 text-center"></i> {{ $item['label'] }}
                        </a>
                    @endforeach
                @endforeach
                
                <form method="POST" action="{{ route('logout') }}" class="mt-4 pt-4 border-t border-slate-800">
                    @csrf
                    <button type="submit" class="w-full text-left flex items-center px-3 py-3 rounded-xl text-sm font-medium text-red-400 hover:bg-slate-800 hover:text-red-300 transition">
                        <i class="fas fa-sign-out-alt w-6 text-center"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div id="toast-success" class="fixed top-20 right-6 z-[9999] px-6 py-3 rounded-xl text-white bg-cyan-500 shadow-2xl transform transition-all duration-500">
            <div class="flex items-center gap-3"><span>{{ session('success') }}</span></div>
        </div>
        <script>setTimeout(() => { const t = document.getElementById('toast-success'); if(t) { t.style.transform = 'translateX(200%)'; setTimeout(() => t.remove(), 500); }}, 3000);</script>
    @endif
    @if(session('warning'))
        <div id="toast-warning" class="fixed top-20 right-6 z-[9999] px-6 py-3 rounded-xl text-white bg-yellow-500 shadow-2xl transform transition-all duration-500">
            <div class="flex items-center gap-3"><span>{{ session('warning') }}</span></div>
        </div>
        <script>setTimeout(() => { const t = document.getElementById('toast-warning'); if(t) { t.style.transform = 'translateX(200%)'; setTimeout(() => t.remove(), 500); }}, 3000);</script>
    @endif
    @if($errors->any())
        <div id="toast-error" class="fixed top-20 right-6 z-[9999] px-6 py-3 rounded-xl text-white bg-red-500 shadow-2xl transform transition-all duration-500">
            <div class="flex items-center gap-3"><i class="fas fa-exclamation-circle"></i><span>{{ $errors->first() }}</span></div>
        </div>
        <script>setTimeout(() => { const t = document.getElementById('toast-error'); if(t) { t.style.transform = 'translateX(200%)'; setTimeout(() => t.remove(), 500); }}, 5000);</script>
    @endif

    {{-- Page Content --}}
    <main class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 fade-in min-h-[80vh] mt-16">
        @yield('content')
    </main>

    @stack('modals')

    {{-- Global Delete Confirmation Modal --}}
    <div id="delete-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="bg-white rounded-[2.5rem] shadow-2xl max-w-sm w-full p-8 scale-in">
            <div class="w-20 h-20 bg-red-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-red-500 shadow-inner">
                <i class="fas fa-trash-alt text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900 text-center mb-2 font-serif">Hapus Data?</h3>
            <p class="text-slate-500 text-sm text-center mb-8 leading-relaxed">Tindakan ini tidak dapat dibatalkan. Semua data terkait akan ikut terhapus secara permanen.</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 py-3.5 rounded-2xl bg-slate-50 text-slate-600 font-bold text-sm hover:bg-slate-100 transition">Batal</button>
                <button id="confirm-delete-btn" class="flex-1 py-3.5 rounded-2xl bg-red-500 text-white font-bold text-sm hover:bg-red-600 transition shadow-lg shadow-red-500/20">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    @stack('scripts')
    <script>
        let formToSubmit = null;
        function confirmDelete(button) {
            formToSubmit = button.closest('form');
            document.getElementById('delete-modal').classList.remove('hidden');
            document.getElementById('delete-modal').classList.add('flex');
        }
        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
            document.getElementById('delete-modal').classList.remove('flex');
            formToSubmit = null;
        }
        document.getElementById('confirm-delete-btn').addEventListener('click', () => {
            if (formToSubmit) {
                const btn = document.getElementById('confirm-delete-btn');
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menghapus...';
                formToSubmit.submit();
            }
        });

        // Dark Mode Logic
        const darkModeToggle = document.getElementById('dark-mode-toggle');
        const darkModeIcon = document.getElementById('dark-mode-icon');
        const html = document.documentElement;
        
        function updateDarkModeIcon() {
            darkModeIcon.classList.add('rotate-in');
            
            setTimeout(() => {
                if (html.classList.contains('dark')) {
                    darkModeIcon.classList.remove('fa-moon');
                    darkModeIcon.classList.add('fa-sun');
                } else {
                    darkModeIcon.classList.remove('fa-sun');
                    darkModeIcon.classList.add('fa-moon');
                }
                darkModeIcon.classList.remove('rotate-in');
            }, 150); // wait halfway to swap icon
        }

        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
            darkModeIcon.classList.add('fa-sun');
        } else {
            html.classList.remove('dark');
            darkModeIcon.classList.add('fa-moon');
        }

        if (darkModeToggle) {
            darkModeToggle.addEventListener('click', () => {
                html.classList.toggle('dark');
                if (html.classList.contains('dark')) {
                    localStorage.setItem('theme', 'dark');
                } else {
                    localStorage.setItem('theme', 'light');
                }
                updateDarkModeIcon();
            });
        }

        // Global Search Logic
        const searchInput = document.getElementById('global-search');
        const searchResults = document.getElementById('search-results');
        
        if (searchInput && searchResults) {
            let searchTimeout;
            
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();
                
                if (query.length < 2) {
                    searchResults.classList.add('hidden');
                    return;
                }
                
                searchTimeout = setTimeout(() => {
                    fetch(`{{ route('search') }}?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(data => {
                            searchResults.innerHTML = '';
                            if (data.results.length === 0) {
                                searchResults.innerHTML = '<div class="p-3 text-sm text-gray-500 text-center dark:bg-slate-800 dark:text-gray-400">Tidak ada hasil</div>';
                            } else {
                                data.results.forEach(item => {
                                    searchResults.innerHTML += `
                                        <a href="${item.url}" class="p-3 flex items-center gap-3 hover:bg-slate-50 dark:hover:bg-slate-700 transition border-b border-gray-100 dark:border-slate-700 last:border-0 dark:bg-slate-800">
                                            <div class="w-8 h-8 rounded-full bg-cyan-50 dark:bg-cyan-900/30 flex items-center justify-center text-cyan-600 dark:text-cyan-400 shrink-0">
                                                <i class="${item.icon} text-xs"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800 dark:text-white">${item.title}</p>
                                                <p class="text-[10px] text-gray-500 dark:text-gray-400">${item.type}</p>
                                            </div>
                                        </a>
                                    `;
                                });
                            }
                            searchResults.classList.remove('hidden');
                            searchResults.classList.add('flex');
                        });
                }, 300);
            });
            
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.add('hidden');
                    searchResults.classList.remove('flex');
                }
            });
        }

        // Mobile menu toggle logic
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        // Progress bar logic
        function startProgress() {
            const bar = document.getElementById('top-progress');
            bar.style.width = '30%';
            bar.style.opacity = '1';
            setTimeout(() => { bar.style.width = '70%'; }, 200);
        }
        window.addEventListener('load', () => {
            const bar = document.getElementById('top-progress');
            if (bar) {
                bar.style.width = '100%';
                setTimeout(() => { bar.style.opacity = '0'; }, 300);
                setTimeout(() => { bar.style.width = '0'; }, 700);
            }
        });

        window.addEventListener('pageshow', (event) => {
            const bar = document.getElementById('top-progress');
            if (bar) {
                bar.style.opacity = '0';
                bar.style.width = '0%';
            }
        });
    </script>
</body>
</html>
