<?php $__env->startSection('title', 'Nilai - Polimicro'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold text-gray-900 mb-2">Nilai Saya</h1>
<p class="text-gray-500 mb-6">Lihat nilai tugas yang sudah dinilai oleh dosen</p>
<div class="grid grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded-2xl border border-gray-100 p-5 text-center"><p class="text-3xl font-bold text-cyan-600"><?php echo e($avg); ?></p><p class="text-xs text-gray-400 mt-1">Rata-rata Nilai</p></div>
    <div class="bg-white rounded-2xl border border-gray-100 p-5 text-center"><p class="text-3xl font-bold text-blue-600"><?php echo e($gradedCount); ?></p><p class="text-xs text-gray-400 mt-1">Tugas Dinilai</p></div>
    <div class="bg-white rounded-2xl border border-gray-100 p-5 text-center"><p class="text-3xl font-bold text-gray-600"><?php echo e($submissions->total() - $gradedCount); ?></p><p class="text-xs text-gray-400 mt-1">Total Tugas</p></div>
</div>
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden mb-6">
    <div class="p-5 border-b border-gray-50"><h3 class="font-bold text-gray-900">Daftar Nilai</h3></div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="bg-gray-50 text-left"><th class="px-5 py-3 font-semibold text-gray-600">Tugas</th><th class="px-5 py-3 font-semibold text-gray-600">Mata Kuliah</th><th class="px-5 py-3 font-semibold text-gray-600">Dikumpul</th><th class="px-5 py-3 font-semibold text-gray-600 text-center">Nilai</th><th class="px-5 py-3 font-semibold text-gray-600 text-center">Grade</th><th class="px-5 py-3 font-semibold text-gray-600">Feedback</th></tr></thead>
            <tbody class="divide-y divide-gray-50">
                <?php $__empty_1 = true; $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $grade = null;
                        if($s->nilai !== null) {
                            if($s->nilai >= 85) $grade = ['A', 'text-cyan-600 bg-cyan-100'];
                            elseif($s->nilai >= 75) $grade = ['B', 'text-blue-600 bg-blue-100'];
                            elseif($s->nilai >= 60) $grade = ['C', 'text-yellow-600 bg-yellow-100'];
                            else $grade = ['D', 'text-red-600 bg-red-100'];
                        }
                    ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4 font-medium">
                            <div class="flex items-center gap-2">
                                <?php echo e($s->tugas->nama_tugas ?? '-'); ?>

                                <a href="<?php echo e(asset('storage/' . $s->file_dikumpul)); ?>" target="_blank" class="text-cyan-600 hover:text-cyan-700" title="Lihat file saya"><i class="fas fa-file-pdf"></i></a>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-gray-500"><?php echo e($s->tugas->makul->nama_makul ?? '-'); ?></td>
                        <td class="px-5 py-4 text-gray-400"><?php echo e($s->waktu_kumpul?->format('d/m/Y') ?? '-'); ?></td>
                        <td class="px-5 py-4 text-center font-bold"><?php echo e($s->nilai !== null ? $s->nilai : '-'); ?></td>
                        <td class="px-5 py-4 text-center"><?php if($grade): ?><span class="px-3 py-1 rounded-full text-xs font-bold <?php echo e($grade[1]); ?>"><?php echo e($grade[0]); ?></span><?php else: ?> - <?php endif; ?></td>
                        <td class="px-5 py-4 text-gray-500 text-xs max-w-[200px] truncate"><?php echo e($s->feedback ?? '-'); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="px-5 py-12 text-center text-gray-400">Belum ada nilai</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    <?php echo e($submissions->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', ['activePage' => 'grades'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\polimicro\resources\views/mahasiswa/grades.blade.php ENDPATH**/ ?>