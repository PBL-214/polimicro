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
    </style>
</head>
<body class="bg-slate-50 text-slate-700">
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
                    ['label' => 'Materi', 'icon' => 'fas fa-file-alt', 'route' => 'mahasiswa.materials', 'id' => 'materials'],
                    ['label' => 'Tugas', 'icon' => 'fas fa-tasks', 'route' => 'mahasiswa.assignments', 'id' => 'assignments'],
                ],
                'RESULTS' => [
                    ['label' => 'Nilai', 'icon' => 'fas fa-chart-bar', 'route' => 'mahasiswa.grades', 'id' => 'grades'],
                    ['label' => 'Sertifikat', 'icon' => 'fas fa-certificate', 'route' => 'mahasiswa.certificates', 'id' => 'certificates'],
                ],
                'ACCOUNT' => [
                    ['label' => 'Profil', 'icon' => 'fas fa-user-cog', 'route' => 'mahasiswa.profile', 'id' => 'profile'],
                ]
            ],
            'dosen' => [
                'MAIN' => [
                    ['label' => 'Dashboard', 'icon' => 'fas fa-th-large', 'route' => 'dosen.dashboard', 'id' => 'dashboard'],
                ],
                'MANAGEMENT' => [
                    ['label' => 'Matkul Saya', 'icon' => 'fas fa-book-open', 'route' => 'dosen.courses', 'id' => 'courses'],
                    ['label' => 'Materi', 'icon' => 'fas fa-file-alt', 'route' => 'dosen.materials', 'id' => 'materials'],
                    ['label' => 'Penugasan', 'icon' => 'fas fa-clipboard-list', 'route' => 'dosen.assignments', 'id' => 'assignments'],
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
                ]
            ],
        ];
        $itemsByGroup = $menus[$role] ?? [];
    @endphp

    {{-- Sidebar --}}
    <aside id="sidebar" class="fixed left-0 top-0 h-full w-64 z-40 flex flex-col transition-transform duration-300 lg:translate-x-0 -translate-x-full shadow-2xl lg:shadow-none bg-slate-800">
        <div class="p-6 border-b border-white/10">
            <a href="{{ route('programs') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-cyan-500 backdrop-blur flex items-center justify-center shadow-lg shadow-cyan-500/20"><i class="fas fa-graduation-cap text-lg text-white"></i></div>
                <span class="text-xl font-bold font-serif text-white tracking-tight">Polimicro</span>
            </a>
        </div>
        <div class="p-4 mx-4 mt-4 rounded-2xl bg-white/5 border border-white/5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-cyan-500/20 border border-cyan-500/30 flex items-center justify-center font-bold text-sm text-cyan-300 shadow-inner">{{ $initials }}</div>
                <div class="overflow-hidden">
                    <p class="font-bold text-sm truncate text-white tracking-wide">{{ $user->name }}</p>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-cyan-400/80">{{ $user->getRoleLabel() }}</p>
                </div>
            </div>
        </div>
        <nav class="flex-1 p-4 space-y-6 overflow-y-auto custom-scrollbar">
            @foreach($itemsByGroup as $group => $items)
                <div class="space-y-1">
                    <p class="text-[10px] text-white/30 font-bold uppercase tracking-[0.2em] px-4 mb-2">{{ $group }}</p>
                    @foreach($items as $item)
                        <a href="{{ route($item['route']) }}" onclick="startProgress()" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ $activePage === $item['id'] ? 'bg-cyan-500 text-white shadow-lg shadow-cyan-500/20' : 'text-slate-400 hover:text-white hover:bg-white/[0.05]' }}">
                            <i class="{{ $item['icon'] }} w-5 text-center text-xs opacity-80"></i>{{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
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

        <div class="p-4 border-t border-white/10 mb-20 lg:mb-0">
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
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-lg shadow-cyan-500/20" style="background:linear-gradient(135deg,#1e293b,#06b6d4)">{{ $initials }}</div>
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
    @php
        $bottomNav = [
            'mahasiswa' => [
                ['label' => 'Dasbor', 'icon' => 'fas fa-th-large', 'route' => 'mahasiswa.dashboard', 'id' => 'dashboard'],
                ['label' => 'Kursus', 'icon' => 'fas fa-book-open', 'route' => 'mahasiswa.courses', 'id' => 'courses'],
                ['label' => 'Tugas', 'icon' => 'fas fa-tasks', 'route' => 'mahasiswa.assignments', 'id' => 'assignments'],
                ['label' => 'Profil', 'icon' => 'fas fa-user-circle', 'route' => 'mahasiswa.profile', 'id' => 'profile'],
            ],
            'dosen' => [
                ['label' => 'Dasbor', 'icon' => 'fas fa-th-large', 'route' => 'dosen.dashboard', 'id' => 'dashboard'],
                ['label' => 'Matkul', 'icon' => 'fas fa-book-open', 'route' => 'dosen.courses', 'id' => 'courses'],
                ['label' => 'Materi', 'icon' => 'fas fa-file-alt', 'route' => 'dosen.materials', 'id' => 'materials'],
                ['label' => 'Kumpul', 'icon' => 'fas fa-inbox', 'route' => 'dosen.submissions', 'id' => 'submissions'],
            ],
            'admin_pic' => [
                ['label' => 'Dasbor', 'icon' => 'fas fa-th-large', 'route' => 'admin-pic.dashboard', 'id' => 'dashboard'],
                ['label' => 'Matkul', 'icon' => 'fas fa-book', 'route' => 'admin-pic.courses', 'id' => 'courses'],
                ['label' => 'Verif', 'icon' => 'fas fa-user-check', 'route' => 'admin-pic.verification', 'id' => 'verification'],
                ['label' => 'Siswa', 'icon' => 'fas fa-users', 'route' => 'admin-pic.students', 'id' => 'students'],
            ],
            'admin_akademik' => [
                ['label' => 'Dasbor', 'icon' => 'fas fa-th-large', 'route' => 'admin-akademik.dashboard', 'id' => 'dashboard'],
                ['label' => 'Prodi', 'icon' => 'fas fa-university', 'route' => 'admin-akademik.programs', 'id' => 'programs'],
                ['label' => 'Dosen', 'icon' => 'fas fa-chalkboard-teacher', 'route' => 'admin-akademik.lecturers', 'id' => 'lecturers'],
                ['label' => 'Sertif', 'icon' => 'fas fa-certificate', 'route' => 'admin-akademik.certificates', 'id' => 'certificates'],
            ],
        ];
        $currentBottomNav = $bottomNav[$role] ?? [];
    @endphp
    <div class="bottom-nav lg:hidden border-t border-slate-100 bg-white/80 backdrop-blur-lg">
        @foreach($currentBottomNav as $item)
            <a href="{{ route($item['route']) }}" class="bottom-nav-item {{ $activePage === $item['id'] ? 'text-cyan-600' : 'text-slate-400' }}">
                <i class="{{ $item['icon'] }}"></i>
                <span class="text-[10px] font-bold uppercase tracking-tighter">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>

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

        function startProgress() {
            const bar = document.getElementById('top-progress');
            bar.style.width = '0%';
            bar.style.opacity = '1';
            
            let w = 0;
            const interval = setInterval(() => {
                if (w < 90) {
                    w += Math.random() * 5;
                    bar.style.width = w + '%';
                }
            }, 200);

            window.addEventListener('load', () => {
                clearInterval(interval);
                bar.style.width = '100%';
                setTimeout(() => {
                    bar.style.opacity = '0';
                    setTimeout(() => bar.style.width = '0%', 400);
                }, 500);
            });
        }

        // Handle browser back/forward
        window.addEventListener('pageshow', (event) => {
            const bar = document.getElementById('top-progress');
            bar.style.opacity = '0';
            bar.style.width = '0%';
        });

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
