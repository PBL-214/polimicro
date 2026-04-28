// ============================================
// POLIMICRO - Mock Data Store
// ============================================

const PoliData = {
  // ---- USERS ----
  users: [
    {
      id: 1,
      nama: "Ahmad Fauzi",
      email: "ahmad@student.polimicro.ac.id",
      password: "mahasiswa123",
      role: "mahasiswa",
      phone: "081234567890",
      address: "Jl. Merdeka No. 10, Bandung",
      avatar: null,
      nim: "2024001",
      status: "aktif"
    },
    {
      id: 2,
      nama: "Siti Nurhaliza",
      email: "siti@student.polimicro.ac.id",
      password: "mahasiswa123",
      role: "mahasiswa",
      phone: "081234567891",
      address: "Jl. Sudirman No. 5, Jakarta",
      avatar: null,
      nim: "2024002",
      status: "aktif"
    },
    {
      id: 3,
      nama: "Budi Santoso",
      email: "budi@student.polimicro.ac.id",
      password: "mahasiswa123",
      role: "mahasiswa",
      phone: "081234567892",
      address: "Jl. Gatot Subroto No. 15, Surabaya",
      avatar: null,
      nim: "2024003",
      status: "aktif"
    },
    {
      id: 4,
      nama: "Dewi Lestari",
      email: "dewi@student.polimicro.ac.id",
      password: "mahasiswa123",
      role: "mahasiswa",
      phone: "081234567893",
      address: "Jl. Diponegoro No. 20, Yogyakarta",
      avatar: null,
      nim: "2024004",
      status: "pending"
    },
    {
      id: 5,
      nama: "Rizky Pratama",
      email: "rizky@student.polimicro.ac.id",
      password: "mahasiswa123",
      role: "mahasiswa",
      phone: "081234567894",
      address: "Jl. Ahmad Yani No. 8, Semarang",
      avatar: null,
      nim: "2024005",
      status: "pending"
    },
    {
      id: 10,
      nama: "Dr. Ir. Hendra Wijaya, M.T.",
      email: "hendra@dosen.polimicro.ac.id",
      password: "dosen123",
      role: "dosen",
      phone: "081298765001",
      address: "Jl. Pahlawan No. 1, Bandung",
      avatar: null,
      nip: "198501012010011001",
      bidang: "Teknologi Informasi"
    },
    {
      id: 11,
      nama: "Prof. Dr. Ratna Sari, M.Kom.",
      email: "ratna@dosen.polimicro.ac.id",
      password: "dosen123",
      role: "dosen",
      phone: "081298765002",
      address: "Jl. Veteran No. 3, Jakarta",
      avatar: null,
      nip: "197801012005012001",
      bidang: "Sistem Informasi"
    },
    {
      id: 12,
      nama: "Dr. Agus Setiawan, M.Sc.",
      email: "agus@dosen.polimicro.ac.id",
      password: "dosen123",
      role: "dosen",
      phone: "081298765003",
      address: "Jl. Pemuda No. 7, Surabaya",
      avatar: null,
      nip: "199001012015011001",
      bidang: "Desain Komunikasi Visual"
    },
    {
      id: 20,
      nama: "Admin PIC Polimicro",
      email: "adminpic@polimicro.ac.id",
      password: "adminpic123",
      role: "admin_pic",
      phone: "081200000001",
      address: "Kampus Polimicro",
      avatar: null
    },
    {
      id: 21,
      nama: "Admin Akademik Polimicro",
      email: "adminakademik@polimicro.ac.id",
      password: "adminakademik123",
      role: "admin_akademik",
      phone: "081200000002",
      address: "Kampus Polimicro",
      avatar: null
    }
  ],

  // ---- PROGRAM STUDI (PRODI) ----
  prodi: [
    {
      id: 1,
      nama: "Teknologi Informasi",
      deskripsi: "Program studi yang mempelajari pengembangan perangkat lunak, jaringan komputer, dan keamanan siber. Lulusan dibekali kemampuan coding, analisis sistem, dan manajemen infrastruktur IT.",
      durasi: "6 Bulan",
      jumlah_matkul: 4,
      status: "aktif",
      icon: "💻",
      image: null
    },
    {
      id: 2,
      nama: "Sistem Informasi",
      deskripsi: "Program studi yang fokus pada perancangan dan pengelolaan sistem informasi bisnis. Mahasiswa belajar analisis kebutuhan, database management, dan business intelligence.",
      durasi: "6 Bulan",
      jumlah_matkul: 4,
      status: "aktif",
      icon: "📊",
      image: null
    },
    {
      id: 3,
      nama: "Desain Komunikasi Visual",
      deskripsi: "Program studi kreatif yang mengajarkan desain grafis, UI/UX design, branding, dan multimedia. Cocok untuk yang ingin berkarir di industri kreatif digital.",
      durasi: "4 Bulan",
      jumlah_matkul: 3,
      status: "aktif",
      icon: "🎨",
      image: null
    },
    {
      id: 4,
      nama: "Digital Marketing",
      deskripsi: "Program studi yang mempelajari strategi pemasaran digital, SEO, social media marketing, content marketing, dan analisis data marketing.",
      durasi: "3 Bulan",
      jumlah_matkul: 3,
      status: "aktif",
      icon: "📱",
      image: null
    },
    {
      id: 5,
      nama: "Data Science",
      deskripsi: "Program studi yang membahas pengolahan dan analisis data besar, machine learning, statistik, dan visualisasi data untuk pengambilan keputusan bisnis.",
      durasi: "6 Bulan",
      jumlah_matkul: 4,
      status: "nonaktif",
      icon: "📈",
      image: null
    }
  ],

  // ---- MATA KULIAH (MATKUL) ----
  matkul: [
    // Prodi: Teknologi Informasi
    { id: 1, nama: "Pemrograman Web", prodi_id: 1, dosen_id: 10, deskripsi: "Dasar-dasar pengembangan web menggunakan HTML, CSS, dan JavaScript.", sks: 3 },
    { id: 2, nama: "Basis Data", prodi_id: 1, dosen_id: 10, deskripsi: "Konsep database relasional, SQL, dan perancangan database.", sks: 3 },
    { id: 3, nama: "Jaringan Komputer", prodi_id: 1, dosen_id: 10, deskripsi: "Konsep jaringan, protokol, dan keamanan jaringan.", sks: 3 },
    { id: 4, nama: "Keamanan Siber", prodi_id: 1, dosen_id: 10, deskripsi: "Pengenalan keamanan informasi dan ethical hacking.", sks: 2 },
    // Prodi: Sistem Informasi
    { id: 5, nama: "Analisis Sistem", prodi_id: 2, dosen_id: 11, deskripsi: "Teknik analisis dan perancangan sistem informasi.", sks: 3 },
    { id: 6, nama: "Manajemen Proyek TI", prodi_id: 2, dosen_id: 11, deskripsi: "Metodologi pengelolaan proyek teknologi informasi.", sks: 2 },
    { id: 7, nama: "Business Intelligence", prodi_id: 2, dosen_id: 11, deskripsi: "Pengolahan data untuk decision support system.", sks: 3 },
    { id: 8, nama: "ERP Systems", prodi_id: 2, dosen_id: 11, deskripsi: "Pengenalan sistem Enterprise Resource Planning.", sks: 3 },
    // Prodi: DKV
    { id: 9, nama: "Desain Grafis", prodi_id: 3, dosen_id: 12, deskripsi: "Prinsip desain visual dan penggunaan tools desain.", sks: 3 },
    { id: 10, nama: "UI/UX Design", prodi_id: 3, dosen_id: 12, deskripsi: "Perancangan antarmuka dan pengalaman pengguna.", sks: 3 },
    { id: 11, nama: "Motion Graphics", prodi_id: 3, dosen_id: 12, deskripsi: "Pembuatan animasi dan grafis bergerak.", sks: 2 },
    // Prodi: Digital Marketing
    { id: 12, nama: "Social Media Marketing", prodi_id: 4, dosen_id: 11, deskripsi: "Strategi pemasaran melalui media sosial.", sks: 2 },
    { id: 13, nama: "SEO & SEM", prodi_id: 4, dosen_id: 11, deskripsi: "Optimasi mesin pencari dan pemasaran berbayar.", sks: 3 },
    { id: 14, nama: "Content Marketing", prodi_id: 4, dosen_id: 12, deskripsi: "Pembuatan dan strategi konten digital.", sks: 2 },
  ],

  // ---- MATERI ----
  materi: [
    { id: 1, matkul_id: 1, judul: "Pengenalan HTML5", konten: "HTML5 adalah versi terbaru dari bahasa markup HyperText Markup Language. Pada materi ini kita akan mempelajari struktur dasar HTML, elemen-elemen penting, dan cara membuat halaman web sederhana.", file_url: "materi_html5.pdf", created_at: "2024-09-01" },
    { id: 2, matkul_id: 1, judul: "CSS Fundamentals", konten: "CSS (Cascading Style Sheets) digunakan untuk mengatur tampilan halaman web. Materi mencakup selector, properties, box model, flexbox, dan grid layout.", file_url: "materi_css.pdf", created_at: "2024-09-08" },
    { id: 3, matkul_id: 1, judul: "JavaScript Dasar", konten: "JavaScript adalah bahasa pemrograman yang membuat halaman web interaktif. Kita akan belajar variabel, fungsi, DOM manipulation, dan event handling.", file_url: "materi_js.pdf", created_at: "2024-09-15" },
    { id: 4, matkul_id: 2, judul: "Pengenalan Database", konten: "Database adalah kumpulan data yang terorganisir. Materi ini membahas konsep DBMS, model data, dan normalisasi database.", file_url: "materi_db_intro.pdf", created_at: "2024-09-01" },
    { id: 5, matkul_id: 2, judul: "SQL Query Dasar", konten: "Structured Query Language (SQL) digunakan untuk mengelola database relasional. Pelajari SELECT, INSERT, UPDATE, DELETE, dan JOIN.", file_url: "materi_sql.pdf", created_at: "2024-09-08" },
    { id: 6, matkul_id: 5, judul: "Metodologi Analisis Sistem", konten: "Pengenalan berbagai metodologi dalam analisis dan perancangan sistem informasi termasuk waterfall, agile, dan prototyping.", file_url: "materi_ansis.pdf", created_at: "2024-09-01" },
    { id: 7, matkul_id: 9, judul: "Prinsip Desain Visual", konten: "Elemen dan prinsip dasar desain visual: warna, tipografi, layout, hierarki visual, dan komposisi.", file_url: "materi_desain.pdf", created_at: "2024-09-01" },
    { id: 8, matkul_id: 10, judul: "Pengantar UI/UX", konten: "Memahami perbedaan UI dan UX, proses design thinking, user research, wireframing, dan prototyping.", file_url: "materi_uiux.pdf", created_at: "2024-09-01" },
  ],

  // ---- TUGAS (ASSIGNMENTS) ----
  tugas: [
    { id: 1, matkul_id: 1, judul: "Membuat Landing Page", deskripsi: "Buatlah sebuah landing page responsif menggunakan HTML5 dan CSS3. Halaman harus memiliki navbar, hero section, dan footer.", deadline: "2024-09-20", created_at: "2024-09-10", max_nilai: 100 },
    { id: 2, matkul_id: 1, judul: "Interactive Web Form", deskripsi: "Buatlah form interaktif dengan validasi menggunakan JavaScript. Form harus memiliki minimal 5 field input.", deadline: "2024-10-05", created_at: "2024-09-20", max_nilai: 100 },
    { id: 3, matkul_id: 2, judul: "Perancangan ERD", deskripsi: "Buatlah Entity Relationship Diagram untuk sistem perpustakaan digital. Minimal 5 entitas dengan relasi yang tepat.", deadline: "2024-09-25", created_at: "2024-09-12", max_nilai: 100 },
    { id: 4, matkul_id: 2, judul: "Query SQL Kompleks", deskripsi: "Kerjakan 10 soal query SQL yang melibatkan JOIN, subquery, dan aggregate functions.", deadline: "2024-10-10", created_at: "2024-09-25", max_nilai: 100 },
    { id: 5, matkul_id: 5, judul: "Dokumen Analisis Kebutuhan", deskripsi: "Buatlah dokumen analisis kebutuhan untuk sistem e-commerce sederhana.", deadline: "2024-09-28", created_at: "2024-09-15", max_nilai: 100 },
    { id: 6, matkul_id: 9, judul: "Desain Poster Event", deskripsi: "Desain poster untuk event kampus menggunakan prinsip desain yang telah dipelajari.", deadline: "2024-09-22", created_at: "2024-09-10", max_nilai: 100 },
    { id: 7, matkul_id: 10, judul: "Wireframe Aplikasi Mobile", deskripsi: "Buat wireframe untuk aplikasi mobile food delivery. Minimal 5 screen.", deadline: "2024-10-01", created_at: "2024-09-18", max_nilai: 100 },
  ],

  // ---- PENGUMPULAN TUGAS (SUBMISSIONS) ----
  submissions: [
    { id: 1, tugas_id: 1, mahasiswa_id: 1, file_url: "ahmad_landing_page.zip", submitted_at: "2024-09-19", nilai: 85, feedback: "Landing page sudah bagus, responsif. Perlu perbaikan di bagian footer." },
    { id: 2, tugas_id: 1, mahasiswa_id: 2, file_url: "siti_landing_page.zip", submitted_at: "2024-09-20", nilai: 92, feedback: "Excellent! Desain sangat kreatif dan clean." },
    { id: 3, tugas_id: 1, mahasiswa_id: 3, file_url: "budi_landing_page.zip", submitted_at: "2024-09-18", nilai: 78, feedback: "Cukup baik, namun belum fully responsive." },
    { id: 4, tugas_id: 2, mahasiswa_id: 1, file_url: "ahmad_form.zip", submitted_at: "2024-10-04", nilai: null, feedback: null },
    { id: 5, tugas_id: 3, mahasiswa_id: 1, file_url: "ahmad_erd.pdf", submitted_at: "2024-09-24", nilai: 90, feedback: "ERD sudah baik, relasi tepat." },
    { id: 6, tugas_id: 3, mahasiswa_id: 2, file_url: "siti_erd.pdf", submitted_at: "2024-09-25", nilai: 88, feedback: "Bagus, tapi ada satu relasi yang kurang tepat." },
    { id: 7, tugas_id: 5, mahasiswa_id: 2, file_url: "siti_analisis.pdf", submitted_at: "2024-09-27", nilai: 95, feedback: "Dokumen sangat lengkap dan terstruktur." },
    { id: 8, tugas_id: 6, mahasiswa_id: 3, file_url: "budi_poster.png", submitted_at: "2024-09-21", nilai: 82, feedback: "Komposisi warna perlu diperbaiki." },
  ],

  // ---- PENDAFTARAN (ENROLLMENT) ----
  pendaftaran: [
    { id: 1, mahasiswa_id: 1, prodi_id: 1, status: "diterima", registered_at: "2024-08-15" },
    { id: 2, mahasiswa_id: 2, prodi_id: 1, status: "diterima", registered_at: "2024-08-16" },
    { id: 3, mahasiswa_id: 2, prodi_id: 2, status: "diterima", registered_at: "2024-08-16" },
    { id: 4, mahasiswa_id: 3, prodi_id: 3, status: "diterima", registered_at: "2024-08-17" },
    { id: 5, mahasiswa_id: 4, prodi_id: 1, status: "pending", registered_at: "2024-09-01" },
    { id: 6, mahasiswa_id: 5, prodi_id: 2, status: "pending", registered_at: "2024-09-02" },
    { id: 7, mahasiswa_id: 1, prodi_id: 2, status: "diterima", registered_at: "2024-08-20" },
    { id: 8, mahasiswa_id: 3, prodi_id: 4, status: "ditolak", registered_at: "2024-08-18" },
  ],

  // ---- SERTIFIKAT ----
  sertifikat: [
    { id: 1, mahasiswa_id: 2, prodi_id: 1, nomor_sertifikat: "CERT-PM-2024-001", tanggal_terbit: "2024-12-15", status: "diterbitkan" },
    { id: 2, mahasiswa_id: 1, prodi_id: 1, nomor_sertifikat: "CERT-PM-2024-002", tanggal_terbit: "2024-12-15", status: "diterbitkan" },
  ],

  // ---- HELPER METHODS ----
  getUserById(id) {
    return this.users.find(u => u.id === id);
  },
  getProdiById(id) {
    return this.prodi.find(p => p.id === id);
  },
  getMatkulById(id) {
    return this.matkul.find(m => m.id === id);
  },
  getMatkulByProdi(prodiId) {
    return this.matkul.filter(m => m.prodi_id === prodiId);
  },
  getMatkulByDosen(dosenId) {
    return this.matkul.filter(m => m.dosen_id === dosenId);
  },
  getMateriByMatkul(matkulId) {
    return this.materi.filter(m => m.matkul_id === matkulId);
  },
  getTugasByMatkul(matkulId) {
    return this.tugas.filter(t => t.matkul_id === matkulId);
  },
  getSubmissionsByTugas(tugasId) {
    return this.submissions.filter(s => s.tugas_id === tugasId);
  },
  getSubmissionsByMahasiswa(mahasiswaId) {
    return this.submissions.filter(s => s.mahasiswa_id === mahasiswaId);
  },
  getPendaftaranByMahasiswa(mahasiswaId) {
    return this.pendaftaran.filter(p => p.mahasiswa_id === mahasiswaId);
  },
  getPendaftaranByProdi(prodiId) {
    return this.pendaftaran.filter(p => p.prodi_id === prodiId);
  },
  getPendingPendaftaran() {
    return this.pendaftaran.filter(p => p.status === "pending");
  },
  getSertifikatByMahasiswa(mahasiswaId) {
    return this.sertifikat.filter(s => s.mahasiswa_id === mahasiswaId);
  },
  getMahasiswaList() {
    return this.users.filter(u => u.role === "mahasiswa");
  },
  getDosenList() {
    return this.users.filter(u => u.role === "dosen");
  },
  getActiveProdi() {
    return this.prodi.filter(p => p.status === "aktif");
  },
  getEnrolledMatkul(mahasiswaId) {
    const enrolledProdi = this.pendaftaran
      .filter(p => p.mahasiswa_id === mahasiswaId && p.status === "diterima")
      .map(p => p.prodi_id);
    return this.matkul.filter(m => enrolledProdi.includes(m.prodi_id));
  }
};

// Initialize from localStorage if available, otherwise use defaults
function initData() {
  const stored = localStorage.getItem('polimicro_data');
  if (stored) {
    const parsed = JSON.parse(stored);
    Object.keys(parsed).forEach(key => {
      if (Array.isArray(parsed[key])) {
        PoliData[key] = parsed[key];
      }
    });
  }
}

function saveData() {
  const dataToSave = {};
  Object.keys(PoliData).forEach(key => {
    if (Array.isArray(PoliData[key])) {
      dataToSave[key] = PoliData[key];
    }
  });
  localStorage.setItem('polimicro_data', JSON.stringify(dataToSave));
}

// Auto-initialize
initData();
