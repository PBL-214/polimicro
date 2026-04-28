<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <title>@yield('title', 'Polimicro')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('design-assets/css/custom.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-700">
    @php
        $user = auth()->user();
        $role = $user->role;
        $initials = $user->getInitials();
        $activePage = $activePage ?? '';

        $menus = [
            'mahasiswa' => [
                ['label' => 'Dashboard', 'icon' => 'fas fa-th-large', 'route' => 'mahasiswa.dashboard', 'id' => 'dashboard'],
                ['label' => 'Mata Kuliah Saya', 'icon' => 'fas fa-book-open', 'route' => 'mahasiswa.courses', 'id' => 'courses'],
                ['label' => 'Materi', 'icon' => 'fas fa-file-alt', 'route' => 'mahasiswa.materials', 'id' => 'materials'],
                ['label' => 'Tugas', 'icon' => 'fas fa-tasks', 'route' => 'mahasiswa.assignments', 'id' => 'assignments'],
                ['label' => 'Nilai', 'icon' => 'fas fa-chart-bar', 'route' => 'mahasiswa.grades', 'id' => 'grades'],
                ['label' => 'Sertifikat', 'icon' => 'fas fa-certificate', 'route' => 'mahasiswa.certificates', 'id' => 'certificates'],
                ['label' => 'Profil', 'icon' => 'fas fa-user-cog', 'route' => 'mahasiswa.profile', 'id' => 'profile'],
            ],
            'dosen' => [
                ['label' => 'Dashboard', 'icon' => 'fas fa-th-large', 'route' => 'dosen.dashboard', 'id' => 'dashboard'],
                ['label' => 'Matkul Saya', 'icon' => 'fas fa-book-open', 'route' => 'dosen.courses', 'id' => 'courses'],
                ['label' => 'Materi', 'icon' => 'fas fa-file-alt', 'route' => 'dosen.materials', 'id' => 'materials'],
                ['label' => 'Penugasan', 'icon' => 'fas fa-clipboard-list', 'route' => 'dosen.assignments', 'id' => 'assignments'],
                ['label' => 'Pengumpulan', 'icon' => 'fas fa-inbox', 'route' => 'dosen.submissions', 'id' => 'submissions'],
                ['label' => 'Mahasiswa', 'icon' => 'fas fa-users', 'route' => 'dosen.students', 'id' => 'students'],
            ],
            'admin_pic' => [
                ['label' => 'Dashboard', 'icon' => 'fas fa-th-large', 'route' => 'admin-pic.dashboard', 'id' => 'dashboard'],
                ['label' => 'Verifikasi', 'icon' => 'fas fa-user-check', 'route' => 'admin-pic.verification', 'id' => 'verification'],
                ['label' => 'Mata Kuliah', 'icon' => 'fas fa-book', 'route' => 'admin-pic.courses', 'id' => 'courses'],
                ['label' => 'Data Pelajar', 'icon' => 'fas fa-user-graduate', 'route' => 'admin-pic.students', 'id' => 'students'],
            ],
            'admin_akademik' => [
                ['label' => 'Dashboard', 'icon' => 'fas fa-th-large', 'route' => 'admin-akademik.dashboard', 'id' => 'dashboard'],
                ['label' => 'Data Dosen', 'icon' => 'fas fa-chalkboard-teacher', 'route' => 'admin-akademik.lecturers', 'id' => 'lecturers'],
                ['label' => 'Program Studi', 'icon' => 'fas fa-university', 'route' => 'admin-akademik.programs', 'id' => 'programs'],
                ['label' => 'Sertifikat', 'icon' => 'fas fa-certificate', 'route' => 'admin-akademik.certificates', 'id' => 'certificates'],
            ],
        ];
        $items = $menus[$role] ?? [];
    @endphp

    {{-- Sidebar --}}
    <aside id="sidebar" class="fixed left-0 top-0 h-full w-64 z-40 flex flex-col transition-transform duration-300 lg:translate-x-0 -translate-x-full" style="background: var(--slate-900);">
        <div class="p-6 border-b border-white/10">
            <a href="{{ route('programs') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-600 backdrop-blur flex items-center justify-center"><i class="fas fa-graduation-cap text-lg text-white"></i></div>
                <span class="text-xl font-bold font-serif text-white">Polimicro</span>
            </a>
        </div>
        <div class="p-4 mx-4 mt-4 rounded-2xl bg-white/10 backdrop-blur border border-white/5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/15 flex items-center justify-center font-bold text-sm text-white">{{ $initials }}</div>
                <div class="overflow-hidden">
                    <p class="font-semibold text-sm truncate text-white">{{ $user->name }}</p>
                    <p class="text-xs text-white/60">{{ $user->getRoleLabel() }}</p>
                </div>
            </div>
        </div>
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <p class="text-xs text-white/40 font-semibold uppercase tracking-wider px-4 mb-2">Menu</p>
            @foreach($items as $item)
                <a href="{{ route($item['route']) }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all {{ $activePage === $item['id'] ? 'bg-white/15 text-white shadow-lg shadow-black/10' : 'text-white/70 hover:text-white hover:bg-white/[0.08]' }}" @if($activePage === $item['id']) style="backdrop-filter:blur(8px)" @endif>
                    <i class="{{ $item['icon'] }} w-5 text-center"></i>{{ $item['label'] }}
                </a>
            @endforeach
        </nav>
        
        <div class="px-4 mb-4">
            <div class="p-4 rounded-xl bg-cyan-900/40 border border-cyan-800/50">
                <i class="fas fa-quote-left text-cyan-400 text-lg mb-2 opacity-50"></i>
                <p class="text-xs text-white/80 font-serif leading-relaxed italic">
                    "Pendidikan adalah senjata paling ampuh yang dapat Anda gunakan untuk mengubah dunia."
                </p>
                <p class="text-[10px] text-cyan-300 mt-2 font-semibold">— Nelson Mandela</p>
            </div>
        </div>

        <div class="p-4 border-t border-white/10">
            <a href="{{ route('programs') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-white/60 hover:text-white rounded-xl hover:bg-white/[0.08] transition"><i class="fas fa-compass w-5 text-center"></i>Jelajahi Program</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-3 text-sm text-white/60 hover:text-white w-full text-left rounded-xl hover:bg-white/[0.08] transition"><i class="fas fa-sign-out-alt w-5 text-center"></i>Keluar</button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div id="main-content" class="lg:ml-64 transition-all">
        {{-- Sidebar Backdrop --}}
        <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-30 opacity-0 invisible transition-all duration-300 lg:hidden"></div>

        {{-- Top Bar --}}
        <header class="sticky top-0 z-30 border-b" style="background:rgba(248,250,252,0.9);backdrop-filter:blur(12px);border-color:#e2e8f0;">
            <div class="flex items-center justify-between px-6 py-4">
                <button onclick="toggleSidebar()" class="lg:hidden text-slate-800 text-xl w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-100 transition"><i class="fas fa-bars"></i></button>
                <div class="flex items-center gap-2">
                    <div class="relative"><i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i><input type="text" placeholder="Cari..." class="pl-9 pr-4 py-2 rounded-xl text-sm border focus:outline-none focus:ring-2 focus:ring-cyan-500/20 w-48 lg:w-64 bg-white border-slate-200"></div>
                </div>
                <div class="flex items-center gap-4">
                    {{-- Notification Center --}}
                    <div class="relative group">
                        <button class="relative text-gray-400 hover:text-gray-900 transition">
                            <i class="fas fa-bell text-lg"></i>
                            @if($unreadCount > 0)
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full border-2 border-white flex items-center justify-center">{{ $unreadCount }}</span>
                            @endif
                        </button>
                        <div class="absolute right-0 mt-3 w-80 glass rounded-2xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 overflow-hidden">
                            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                                <h4 class="font-bold text-sm">Notifikasi</h4>
                                @if($unreadCount > 0)
                                    <span class="text-[10px] text-cyan-600 font-semibold cursor-pointer">Tandai semua dibaca</span>
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
                                            <p class="text-[10px] text-gray-400 leading-tight mt-0.5">{{ $notif->data['message'] ?? '' }}</p>
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
                            @if($notifications->count() > 0)
                                <a href="#" class="block p-3 text-center text-xs font-bold text-cyan-600 bg-gray-50 hover:bg-gray-100">Lihat Semua Notifikasi</a>
                            @endif
                        </div>
                    </div>
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-lg shadow-green-500/20" style="background:linear-gradient(135deg,#1B5E20,#4CAF50)">{{ $initials }}</div>
                </div>
            </div>
        </header>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div id="toast-success" class="fixed top-6 right-6 z-[9999] px-6 py-3 rounded-xl text-white bg-cyan-500 shadow-2xl transform transition-all duration-500">
                <div class="flex items-center gap-3"><span>{{ session('success') }}</span></div>
            </div>
            <script>setTimeout(() => { const t = document.getElementById('toast-success'); if(t) { t.style.transform = 'translateX(200%)'; setTimeout(() => t.remove(), 500); }}, 3000);</script>
        @endif
        @if(session('warning'))
            <div id="toast-warning" class="fixed top-6 right-6 z-[9999] px-6 py-3 rounded-xl text-white bg-yellow-500 shadow-2xl transform transition-all duration-500">
                <div class="flex items-center gap-3"><span>{{ session('warning') }}</span></div>
            </div>
            <script>setTimeout(() => { const t = document.getElementById('toast-warning'); if(t) { t.style.transform = 'translateX(200%)'; setTimeout(() => t.remove(), 500); }}, 3000);</script>
        @endif
        @if($errors->any())
            <div id="toast-error" class="fixed top-6 right-6 z-[9999] px-6 py-3 rounded-xl text-white bg-red-500 shadow-2xl transform transition-all duration-500">
                <div class="flex items-center gap-3"><i class="fas fa-exclamation-circle"></i><span>{{ $errors->first() }}</span></div>
            </div>
            <script>setTimeout(() => { const t = document.getElementById('toast-error'); if(t) { t.style.transform = 'translateX(200%)'; setTimeout(() => t.remove(), 500); }}, 5000);</script>
        @endif

        {{-- Page Content --}}
        <main class="p-6 lg:p-8 fade-in pb-24 lg:pb-8">
            @yield('content')
        </main>
    </div>

    {{-- Bottom Navigation for Mobile --}}
    <div class="bottom-nav lg:hidden">
        <a href="{{ route($user->getDashboardRoute()) }}" class="bottom-nav-item {{ $activePage === 'dashboard' ? 'active' : '' }}">
            <i class="fas fa-th-large"></i>
            <span>Dasbor</span>
        </a>
        <a href="{{ $role === 'mahasiswa' ? route('mahasiswa.courses') : '#' }}" class="bottom-nav-item {{ $activePage === 'courses' ? 'active' : '' }}">
            <i class="fas fa-book-open"></i>
            <span>Kursus</span>
        </a>
        <a href="{{ $role === 'mahasiswa' ? route('mahasiswa.assignments') : '#' }}" class="bottom-nav-item {{ $activePage === 'assignments' ? 'active' : '' }}">
            <i class="fas fa-tasks"></i>
            <span>Tugas</span>
        </a>
        <a href="{{ $role === 'mahasiswa' ? route('mahasiswa.profile') : '#' }}" class="bottom-nav-item {{ $activePage === 'profile' ? 'active' : '' }}">
            <i class="fas fa-user-circle"></i>
            <span>Profil</span>
        </a>
    </div>

    @stack('modals')
    @stack('scripts')
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const isClosed = sidebar.classList.contains('-translate-x-full');

            if (isClosed) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('invisible', 'opacity-0');
                backdrop.classList.add('opacity-100');
                document.body.style.overflow = 'hidden';
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('opacity-0');
                setTimeout(() => {
                    if (sidebar.classList.contains('-translate-x-full')) {
                        backdrop.classList.add('invisible');
                    }
                }, 300);
                document.body.style.overflow = '';
            }
        }
    </script>
</body>
</html>
