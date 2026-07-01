<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FAQ - Polimicro</title>
  <link rel="icon" href="<?php echo e(asset('design-assets/img/favicon.ico')); ?>" type="image/x-icon">
  <link rel="preconnect" href="https://cdnjs.cloudflare.com">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="<?php echo e(asset('design-assets/css/custom.css')); ?>">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 text-slate-600">

  <!-- Navbar -->
  <nav id="navbar" class="fixed top-0 w-full z-50 transition-all duration-300 bg-white/90 backdrop-blur border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
      <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-cyan-600 flex items-center justify-center">
          <i class="fas fa-graduation-cap text-white text-lg"></i>
        </div>
        <span class="text-2xl font-bold font-serif text-slate-800">Polimicro</span>
      </a>
      <div class="hidden md:flex items-center gap-8">
        <a href="<?php echo e(route('home')); ?>" class="nav-link text-slate-600 hover:text-cyan-600 font-medium transition">Beranda</a>
        <a href="<?php echo e(route('programs')); ?>" class="nav-link text-slate-600 hover:text-cyan-600 font-medium transition">Program</a>
        <a href="<?php echo e(route('faq')); ?>" class="nav-link text-cyan-600 font-semibold transition">FAQ</a>
      </div>
      <div class="hidden md:flex items-center gap-3">
        <?php if(auth()->guard()->check()): ?>
          <div class="relative group">
            <button class="flex items-center gap-2 px-3 py-2 rounded-xl border border-slate-200 hover:border-cyan-300 transition bg-white">
              <div class="w-8 h-8 rounded-full bg-cyan-100 flex items-center justify-center text-cyan-700 font-bold text-sm">
                <?php echo e(auth()->user()->getInitials()); ?>

              </div>
              <span class="text-sm font-medium text-slate-700 max-w-[100px] truncate"><?php echo e(auth()->user()->name); ?></span>
              <i class="fas fa-chevron-down text-xs text-slate-400"></i>
            </button>
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 py-2">
              <a href="<?php echo e(route(auth()->user()->getDashboardRoute())); ?>" class="block px-4 py-2 text-sm text-slate-600 hover:bg-cyan-50 hover:text-cyan-700"><i class="fas fa-th-large mr-2"></i>Dasbor Saya</a>
              <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"><i class="fas fa-sign-out-alt mr-2"></i>Keluar</button>
              </form>
            </div>
          </div>
        <?php else: ?>
          <a href="<?php echo e(route('login')); ?>" class="px-5 py-2.5 rounded-xl text-slate-800 border border-slate-300 hover:border-cyan-600 font-medium transition">Masuk</a>
          <a href="<?php echo e(route('register')); ?>" class="px-5 py-2.5 rounded-xl bg-cyan-600 text-white font-semibold hover:bg-cyan-700 transition shadow-lg">Daftar</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <!-- FAQ Hero -->
  <section class="pt-40 pb-20 bg-slate-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
    <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
      <h1 class="text-5xl font-bold font-serif mb-6">Pertanyaan yang Sering Diajukan</h1>
      <p class="text-cyan-100 text-lg mb-10">Temukan jawaban atas pertanyaan seputar program Microcredential, pendaftaran, dan benefit yang akan Anda dapatkan.</p>
      <div class="relative max-w-2xl mx-auto">
        <input type="text" id="faq-search" class="w-full pl-14 pr-6 py-4 rounded-2xl bg-white/10 border border-white/20 text-white placeholder-cyan-200 focus:outline-none focus:ring-2 focus:ring-cyan-500 backdrop-blur transition" placeholder="Cari pertanyaan...">
        <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-cyan-200 text-lg"></i>
      </div>
    </div>
  </section>

  <!-- FAQ Content -->
  <section class="py-20">
    <div class="max-w-3xl mx-auto px-6">
      <div class="space-y-4" id="faq-container">
        <!-- FAQ Item 1 -->
        <div class="faq-item bg-white border border-slate-200 rounded-2xl p-6 transition hover:border-cyan-300 shadow-sm cursor-pointer" onclick="toggleFaq(this)">
          <div class="flex justify-between items-center gap-4">
            <h3 class="font-serif font-bold text-lg text-slate-800">Apa itu Microcredential di Polimicro?</h3>
            <i class="fas fa-chevron-down text-slate-400 transition-transform"></i>
          </div>
          <div class="faq-answer mt-4 text-slate-600 text-sm hidden">
            <p>Microcredential adalah program sertifikasi jangka pendek yang dirancang untuk membekali Anda dengan keterampilan spesifik yang sangat relevan dengan kebutuhan industri saat ini. Berbeda dengan gelar sarjana, program ini fokus pada kompetensi teknis praktis.</p>
          </div>
        </div>
        <!-- FAQ Item 2 -->
        <div class="faq-item bg-white border border-slate-200 rounded-2xl p-6 transition hover:border-cyan-300 shadow-sm cursor-pointer" onclick="toggleFaq(this)">
          <div class="flex justify-between items-center gap-4">
            <h3 class="font-serif font-bold text-lg text-slate-800">Apakah program ini gratis?</h3>
            <i class="fas fa-chevron-down text-slate-400 transition-transform"></i>
          </div>
          <div class="faq-answer mt-4 text-slate-600 text-sm hidden">
            <p>Ya, seluruh program Microcredential saat ini tersedia secara gratis bagi mahasiswa yang sudah terdaftar dan akunnya telah diverifikasi oleh Admin PIC. Kami berkomitmen untuk membuka akses pendidikan berkualitas seluas-luasnya.</p>
          </div>
        </div>
        <!-- FAQ Item 3 -->
        <div class="faq-item bg-white border border-slate-200 rounded-2xl p-6 transition hover:border-cyan-300 shadow-sm cursor-pointer" onclick="toggleFaq(this)">
          <div class="flex justify-between items-center gap-4">
            <h3 class="font-serif font-bold text-lg text-slate-800">Bagaimana proses mendapatkan sertifikat?</h3>
            <i class="fas fa-chevron-down text-slate-400 transition-transform"></i>
          </div>
          <div class="faq-answer mt-4 text-slate-600 text-sm hidden">
            <p>Anda harus mendaftar ke program studi, mempelajari materi yang diberikan oleh dosen, dan mengerjakan semua tugas akhir. Jika nilai rata-rata Anda memenuhi standar kelulusan, Anda akan secara otomatis mendapatkan sertifikat digital.</p>
          </div>
        </div>
        <!-- FAQ Item 4 -->
        <div class="faq-item bg-white border border-slate-200 rounded-2xl p-6 transition hover:border-cyan-300 shadow-sm cursor-pointer" onclick="toggleFaq(this)">
          <div class="flex justify-between items-center gap-4">
            <h3 class="font-serif font-bold text-lg text-slate-800">Apakah sertifikat ini diakui industri?</h3>
            <i class="fas fa-chevron-down text-slate-400 transition-transform"></i>
          </div>
          <div class="faq-answer mt-4 text-slate-600 text-sm hidden">
            <p>Sertifikat Microcredential Polimicro diterbitkan bekerja sama dengan mitra industri terkemuka. Ini dapat Anda cantumkan di CV atau profil LinkedIn sebagai bukti kompetensi spesifik yang Anda kuasai.</p>
          </div>
        </div>
        <!-- FAQ Item 5 -->
        <div class="faq-item bg-white border border-slate-200 rounded-2xl p-6 transition hover:border-cyan-300 shadow-sm cursor-pointer" onclick="toggleFaq(this)">
          <div class="flex justify-between items-center gap-4">
            <h3 class="font-serif font-bold text-lg text-slate-800">Bagaimana jika saya kesulitan mengakses materi?</h3>
            <i class="fas fa-chevron-down text-slate-400 transition-transform"></i>
          </div>
          <div class="faq-answer mt-4 text-slate-600 text-sm hidden">
            <p>Jika Anda mengalami kendala teknis atau memiliki pertanyaan seputar materi, Anda dapat menghubungi dosen pengampu secara langsung, atau menghubungi layanan bantuan di info@polimicro.ac.id.</p>
          </div>
        </div>
      </div>
      
      <div id="no-results" class="hidden text-center py-12">
        <i class="fas fa-search text-4xl text-slate-300 mb-4 block"></i>
        <p class="text-slate-500">Tidak ada pertanyaan yang sesuai dengan pencarian Anda.</p>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="py-20 bg-slate-100 border-t border-slate-200 text-center">
    <div class="max-w-2xl mx-auto px-6">
      <h2 class="text-3xl font-serif font-bold text-slate-800 mb-4">Masih Punya Pertanyaan?</h2>
      <p class="text-slate-600 mb-8">Tim support kami siap membantu Anda dengan informasi lebih detail.</p>
      <a href="mailto:info@polimicro.ac.id" class="inline-flex items-center gap-2 px-8 py-3 rounded-xl bg-cyan-600 text-white font-semibold hover:bg-cyan-700 transition">
        <i class="fas fa-envelope"></i> Hubungi Kami
      </a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-slate-900 text-slate-300 py-12 border-t border-slate-800 text-center">
    <p>&copy; <span id="year"></span> Polimicro. All rights reserved.</p>
  </footer>

  <script>
    document.getElementById('year').textContent = new Date().getFullYear();

    function toggleFaq(el) {
      const answer = el.querySelector('.faq-answer');
      const icon = el.querySelector('.fa-chevron-down');
      
      // Close others
      document.querySelectorAll('.faq-answer').forEach(ans => {
        if (ans !== answer && !ans.classList.contains('hidden')) {
          ans.classList.add('hidden');
          ans.previousElementSibling.querySelector('.fa-chevron-down').style.transform = 'rotate(0deg)';
        }
      });
      
      // Toggle current
      if (answer.classList.contains('hidden')) {
        answer.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
      } else {
        answer.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
      }
    }

    // Search functionality
    document.getElementById('faq-search').addEventListener('input', function(e) {
      const query = e.target.value.toLowerCase();
      const items = document.querySelectorAll('.faq-item');
      let found = false;

      items.forEach(item => {
        const text = item.textContent.toLowerCase();
        if (text.includes(query)) {
          item.style.display = 'block';
          found = true;
        } else {
          item.style.display = 'none';
        }
      });

      document.getElementById('no-results').style.display = found ? 'none' : 'block';
    });
  </script>
</body>
</html>
<?php /**PATH C:\laragon\www\polimicro\resources\views/faq.blade.php ENDPATH**/ ?>