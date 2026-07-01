<?php $__env->startSection('title', 'Materi - Polimicro'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold text-gray-900 mb-2">Materi Pembelajaran</h1>
<p class="text-gray-500 mb-6">Akses materi dari mata kuliah yang Anda ikuti</p>
<div class="mb-6">
    <select id="filter" class="px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm" onchange="window.location='<?php echo e(route('mahasiswa.materials')); ?>?matkul='+this.value">
        <option value="">Semua Mata Kuliah</option>
        <?php $__currentLoopData = $enrolled; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($m->id); ?>" <?php echo e($filterMatkul == $m->id ? 'selected' : ''); ?>><?php echo e($m->nama_makul); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>
<div class="space-y-4">
    <?php $filtered = $filterMatkul ? $enrolled->where('id', $filterMatkul) : $enrolled; ?>
    <?php $__empty_1 = true; $__currentLoopData = $filtered; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php if($m->materi->count() > 0): ?>
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-50 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center text-white"><i class="fas fa-book"></i></div>
                <div><h3 class="font-bold text-gray-900"><?php echo e($m->nama_makul); ?></h3><p class="text-xs text-gray-400"><?php echo e($m->materi->count()); ?> materi tersedia</p></div>
            </div>
            <div class="divide-y divide-gray-50">
                <?php $__currentLoopData = $m->materi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="p-5 hover:bg-cyan-50/50 transition cursor-pointer" onclick="this.querySelector('.detail').classList.toggle('hidden')">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-cyan-100 flex items-center justify-center"><i class="fas fa-file-alt text-cyan-600 text-sm"></i></div>
                            <div><p class="font-semibold text-sm"><?php echo e($mat->nama_materi); ?></p><p class="text-xs text-gray-400"><?php echo e($mat->created_at->translatedFormat('j F Y')); ?></p></div>
                        </div>
                        <i class="fas fa-chevron-down text-gray-300 text-sm"></i>
                    </div>
                    <div class="detail hidden mt-4 p-4 bg-gray-50 rounded-xl text-sm text-gray-600">
                        <p><?php echo e($mat->deskripsi_materi); ?></p>
                        <div class="mt-3 flex items-center gap-2">
                            <?php if($mat->file_materi): ?>
                                <a href="<?php echo e(asset('storage/' . $mat->file_materi)); ?>" target="_blank" class="px-4 py-2 bg-[#0E7490] text-white rounded-lg text-xs font-medium hover:bg-[#155E75] transition inline-flex items-center gap-2">
                                    <i class="fas fa-file-download"></i>
                                    <?php echo e(basename($mat->file_materi)); ?>

                                </a>
                            <?php else: ?>
                                <span class="text-xs text-gray-400 italic">Tidak ada file lampiran</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-center py-16 text-gray-400"><i class="fas fa-folder-open text-4xl mb-4"></i><p>Belum ada materi tersedia</p></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', ['activePage' => 'materials'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\polimicro\resources\views/mahasiswa/materials.blade.php ENDPATH**/ ?>