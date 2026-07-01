<?php $__env->startSection('title', 'Mata Kuliah Saya - Polimicro'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold text-gray-900 mb-2">Mata Kuliah Saya</h1>
<p class="text-gray-500 mb-6">Daftar mata kuliah yang Anda ikuti</p>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php $__empty_1 = true; $__currentLoopData = $enrolled; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-[2rem] border border-slate-100 overflow-hidden card-hover group">
            <div class="bg-gradient-to-br from-slate-800 to-slate-900 p-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-[10px] font-bold uppercase tracking-widest text-cyan-400"><?php echo e($m->prodi->nama_prodi ?? ''); ?></span>
                    <i class="fas fa-bookmark text-cyan-500 opacity-50 group-hover:opacity-100 transition"></i>
                </div>
                <h3 class="font-bold text-white text-lg group-hover:text-cyan-400 transition"><?php echo e($m->nama_makul); ?></h3>
            </div>
            <div class="p-6">
                <p class="text-slate-500 text-sm mb-6 line-clamp-2 leading-relaxed"><?php echo e($m->deskripsi ?: 'Kuasai kompetensi mendalam melalui kurikulum terstruktur dan bimbingan ahli.'); ?></p>
                
                
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Progres Belajar</span>
                        <span class="text-xs font-bold text-cyan-600"><?php echo e($m->progress); ?>%</span>
                    </div>
                    <div class="w-full h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-cyan-600 rounded-full transition-all duration-1000" style="width: <?php echo e($m->progress); ?>%"></div>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-cyan-50 flex items-center justify-center text-[10px] font-bold text-cyan-700 border border-white shadow-sm"><?php echo e($m->dosen ? $m->dosen->getInitials() : '?'); ?></div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-800 leading-none"><?php echo e($m->dosen->name ?? '-'); ?></p>
                            <p class="text-[9px] text-slate-400 mt-0.5">Dosen Pengampu</p>
                        </div>
                    </div>
                    <div class="flex gap-3 text-slate-400">
                        <div class="text-center"><p class="text-xs font-bold text-slate-700 leading-none"><?php echo e($m->materi->count()); ?></p><p class="text-[8px] uppercase font-bold tracking-tighter mt-0.5">Materi</p></div>
                        <div class="text-center"><p class="text-xs font-bold text-slate-700 leading-none"><?php echo e($m->tugas->count()); ?></p><p class="text-[8px] uppercase font-bold tracking-tighter mt-0.5">Tugas</p></div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="<?php echo e(route('mahasiswa.materials', ['matkul' => $m->id])); ?>" class="flex-1 py-3 bg-cyan-600 text-white rounded-xl text-xs font-bold shadow-lg shadow-cyan-600/20 hover:bg-cyan-700 transition active:scale-95 flex items-center justify-center gap-2">
                        <i class="fas fa-play text-[9px]"></i> Materi
                    </a>
                    <a href="<?php echo e(route('mahasiswa.assignments', ['matkul' => $m->id])); ?>" class="flex-1 py-3 bg-slate-50 text-slate-700 rounded-xl text-xs font-bold border border-slate-100 hover:bg-slate-100 transition flex items-center justify-center gap-2">
                        <i class="fas fa-tasks text-[10px]"></i> Tugas
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full py-20 text-center">
            <div class="w-20 h-20 bg-slate-100 rounded-3xl flex items-center justify-center mx-auto mb-6"><i class="fas fa-book-open text-3xl text-slate-300"></i></div>
            <h3 class="font-bold text-slate-900 mb-2">Belum Ada Mata Kuliah</h3>
            <p class="text-slate-500 text-sm mb-8">Daftar ke program studi untuk memulai perjalanan belajar Anda.</p>
            <a href="<?php echo e(route('programs')); ?>" class="px-8 py-3 bg-cyan-600 text-white rounded-xl font-bold text-sm shadow-xl shadow-cyan-600/20">Cari Program</a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', ['activePage' => 'courses'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\polimicro\resources\views/mahasiswa/courses.blade.php ENDPATH**/ ?>