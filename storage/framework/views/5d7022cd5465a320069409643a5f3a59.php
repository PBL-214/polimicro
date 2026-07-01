<?php $__env->startSection('title', 'Daftar Mahasiswa - Dosen - Polimicro'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold text-gray-900 mb-2">Daftar Mahasiswa</h1>
<p class="text-gray-500 mb-6">Mahasiswa yang terdaftar per mata kuliah</p>
<?php $__currentLoopData = $myMatkul; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php $enrollments = $m->prodi->pendaftaranDiterima()->with('mahasiswa')->get(); ?>
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden mb-6">
        <div class="p-5 border-b border-gray-50 flex justify-between"><h3 class="font-bold"><?php echo e($m->nama_makul); ?></h3><span class="text-sm text-gray-400"><?php echo e($enrollments->count()); ?> mahasiswa</span></div>
        <div class="overflow-x-auto"><table class="w-full text-sm">
            <thead><tr class="bg-gray-50" style="background:#faf8f5"><th class="px-5 py-3 text-left font-semibold text-gray-600">No</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Mahasiswa</th><th class="px-5 py-3 text-left font-semibold text-gray-600">NIM</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Email</th></tr></thead>
            <tbody class="divide-y divide-gray-50">
            <?php $__empty_1 = true; $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php if($e->mahasiswa): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-4 text-gray-400"><?php echo e($i + 1); ?></td>
                    <td class="px-5 py-4"><div class="flex items-center gap-3"><div class="w-8 h-8 rounded-full bg-cyan-100 flex items-center justify-center text-xs font-bold text-cyan-700"><?php echo e($e->mahasiswa->getInitials()); ?></div><span class="font-medium"><?php echo e($e->mahasiswa->name); ?></span></div></td>
                    <td class="px-5 py-4 text-gray-500 font-mono text-xs"><?php echo e($e->mahasiswa->nim ?? '-'); ?></td>
                    <td class="px-5 py-4 text-gray-500 text-xs"><?php echo e($e->mahasiswa->email); ?></td>
                </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="4" class="px-5 py-12 text-center text-gray-400">Belum ada mahasiswa terdaftar</td></tr>
            <?php endif; ?>
            </tbody>
        </table></div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<div class="mt-6">
    <?php echo e($myMatkul->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', ['activePage' => 'students'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\polimicro\resources\views/dosen/students.blade.php ENDPATH**/ ?>