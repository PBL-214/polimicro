<?php $__env->startSection('title', 'Matkul Saya - Dosen - Polimicro'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold text-gray-900 mb-2">Mata Kuliah Saya</h1>
<p class="text-gray-500 mb-6">Daftar mata kuliah yang Anda ampu</p>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php $__currentLoopData = $myMatkul; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php $materiCount = $m->materi->count(); $tugasCount = $m->tugas->count(); $studentCount = $m->prodi->pendaftaranDiterima->count(); ?>
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden card-hover">
        <div class="gradient-card p-5"><h3 class="font-bold text-cyan-900"><?php echo e($m->nama_makul); ?></h3><p class="text-cyan-700 text-xs mt-1"><?php echo e($m->prodi->nama_prodi ?? ''); ?></p></div>
        <div class="p-5">
            <p class="text-gray-500 text-sm mb-4"><?php echo e($m->deskripsi); ?></p>
            <div class="grid grid-cols-3 gap-2 text-center mb-4">
                <div class="p-2 bg-gray-50 rounded-lg"><p class="font-bold text-sm"><?php echo e($materiCount); ?></p><p class="text-[10px] text-gray-400">Materi</p></div>
                <div class="p-2 bg-gray-50 rounded-lg"><p class="font-bold text-sm"><?php echo e($tugasCount); ?></p><p class="text-[10px] text-gray-400">Tugas</p></div>
                <div class="p-2 bg-gray-50 rounded-lg"><p class="font-bold text-sm"><?php echo e($studentCount); ?></p><p class="text-[10px] text-gray-400">Mahasiswa</p></div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <a href="<?php echo e(route('dosen.materials', ['matkul' => $m->id])); ?>" class="text-center py-2 text-xs btn-primary text-white rounded-xl font-medium">Materi</a>
                <a href="<?php echo e(route('dosen.assignments')); ?>" class="text-center py-2 text-xs bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200">Tugas</a>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<div class="mt-8">
    <?php echo e($myMatkul->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', ['activePage' => 'courses'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\polimicro\resources\views/dosen/courses.blade.php ENDPATH**/ ?>