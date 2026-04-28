// POLIMICRO - Sidebar Component Builder (Warm Premium Theme)
function buildSidebar(role, activePage) {
  const base = Auth.getBasePath();
  const menus = {
    mahasiswa: [
      { label: 'Dashboard', icon: 'fas fa-th-large', href: base + 'student/dashboard.html', id: 'dashboard' },
      { label: 'Mata Kuliah Saya', icon: 'fas fa-book-open', href: base + 'student/my-courses.html', id: 'my-courses' },
      { label: 'Materi', icon: 'fas fa-file-alt', href: base + 'student/materials.html', id: 'materials' },
      { label: 'Tugas', icon: 'fas fa-tasks', href: base + 'student/assignments.html', id: 'assignments' },
      { label: 'Nilai', icon: 'fas fa-chart-bar', href: base + 'student/grades.html', id: 'grades' },
      { label: 'Sertifikat', icon: 'fas fa-certificate', href: base + 'student/certificates.html', id: 'certificates' },
      { label: 'Profil', icon: 'fas fa-user-cog', href: base + 'student/profile.html', id: 'profile' },
    ],
    dosen: [
      { label: 'Dashboard', icon: 'fas fa-th-large', href: base + 'dosen/dashboard.html', id: 'dashboard' },
      { label: 'Matkul Saya', icon: 'fas fa-book-open', href: base + 'dosen/my-courses.html', id: 'my-courses' },
      { label: 'Materi', icon: 'fas fa-file-alt', href: base + 'dosen/materials.html', id: 'materials' },
      { label: 'Penugasan', icon: 'fas fa-clipboard-list', href: base + 'dosen/assignments.html', id: 'assignments' },
      { label: 'Pengumpulan', icon: 'fas fa-inbox', href: base + 'dosen/submissions.html', id: 'submissions' },
      { label: 'Mahasiswa', icon: 'fas fa-users', href: base + 'dosen/students.html', id: 'students' },
    ],
    admin_pic: [
      { label: 'Dashboard', icon: 'fas fa-th-large', href: base + 'admin-pic/dashboard.html', id: 'dashboard' },
      { label: 'Verifikasi', icon: 'fas fa-user-check', href: base + 'admin-pic/verification.html', id: 'verification' },
      { label: 'Mata Kuliah', icon: 'fas fa-book', href: base + 'admin-pic/courses.html', id: 'courses' },
      { label: 'Data Pelajar', icon: 'fas fa-user-graduate', href: base + 'admin-pic/students.html', id: 'students' },
    ],
    admin_akademik: [
      { label: 'Dashboard', icon: 'fas fa-th-large', href: base + 'admin-akademik/dashboard.html', id: 'dashboard' },
      { label: 'Data Dosen', icon: 'fas fa-chalkboard-teacher', href: base + 'admin-akademik/lecturers.html', id: 'lecturers' },
      { label: 'Program Studi', icon: 'fas fa-university', href: base + 'admin-akademik/programs.html', id: 'programs' },
      { label: 'Sertifikat', icon: 'fas fa-certificate', href: base + 'admin-akademik/certificates.html', id: 'certificates' },
    ]
  };

  const user = Auth.getCurrentUser();
  const items = menus[role] || [];
  const initials = user ? Utils.getInitials(user.nama) : '?';

  return `
  <aside id="sidebar" class="fixed left-0 top-0 h-full w-64 z-40 flex flex-col transition-transform duration-300 lg:translate-x-0 -translate-x-full" style="background: linear-gradient(180deg, #0D3B12 0%, #1B5E20 50%, #2E7D32 100%);">
    <div class="p-6 border-b border-white/10">
      <a href="${base}index.html" class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-white/15 backdrop-blur flex items-center justify-center"><i class="fas fa-graduation-cap text-lg text-white"></i></div>
        <span class="text-xl font-bold text-white">Polimicro</span>
      </a>
    </div>
    <div class="p-4 mx-4 mt-4 rounded-2xl bg-white/10 backdrop-blur border border-white/5">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-white/15 flex items-center justify-center font-bold text-sm text-white">${initials}</div>
        <div class="overflow-hidden"><p class="font-semibold text-sm truncate text-white">${user ? user.nama : ''}</p><p class="text-xs text-white/60">${Auth.getRoleLabel(role)}</p></div>
      </div>
    </div>
    <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
      <p class="text-xs text-white/40 font-semibold uppercase tracking-wider px-4 mb-2">Menu</p>
      ${items.map(item => `<a href="${item.href}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all ${activePage === item.id ? 'bg-white/15 text-white shadow-lg shadow-black/10' : 'text-white/70 hover:text-white hover:bg-white/8'}" style="${activePage === item.id ? 'backdrop-filter:blur(8px)' : ''}"><i class="${item.icon} w-5 text-center"></i>${item.label}</a>`).join('')}
    </nav>
    <div class="p-4 border-t border-white/10">
      <a href="${base}programs.html" class="flex items-center gap-3 px-4 py-3 text-sm text-white/60 hover:text-white rounded-xl hover:bg-white/8 transition"><i class="fas fa-compass w-5 text-center"></i>Jelajahi Program</a>
      <button onclick="Auth.logout()" class="flex items-center gap-3 px-4 py-3 text-sm text-white/60 hover:text-white w-full text-left rounded-xl hover:bg-white/8 transition"><i class="fas fa-sign-out-alt w-5 text-center"></i>Keluar</button>
    </div>
  </aside>
  <!-- Top Bar -->
  <div class="lg:ml-64 transition-all">
    <header class="sticky top-0 z-30 border-b" style="background:rgba(250,248,245,0.9);backdrop-filter:blur(12px);border-color:#e8e4df;">
      <div class="flex items-center justify-between px-6 py-4">
        <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')" class="lg:hidden text-[#1a1a2e] text-xl"><i class="fas fa-bars"></i></button>
        <div class="flex items-center gap-2">
          <div class="relative"><i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-[#8b8ba3] text-sm"></i><input type="text" placeholder="Cari..." class="pl-9 pr-4 py-2 rounded-xl text-sm border focus:ring-2 focus:ring-green-500/20 w-48 lg:w-64" style="background:#f5f0eb;border-color:#e8e4df;"></div>
        </div>
        <div class="flex items-center gap-4">
          <button class="relative text-[#8b8ba3] hover:text-[#1a1a2e] transition"><i class="fas fa-bell text-lg"></i><span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full text-white text-[10px] flex items-center justify-center">3</span></button>
          <div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm font-bold" style="background:linear-gradient(135deg,#1B5E20,#4CAF50)">${initials}</div>
        </div>
      </div>
    </header>`;
}

function closeSidebarLayout() {
  return `</div>`;
}
