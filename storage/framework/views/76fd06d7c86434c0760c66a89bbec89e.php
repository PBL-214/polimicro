<?php $__env->startSection('title', 'Tugas - Polimicro'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold text-gray-900 mb-2">Tugas</h1>
<p class="text-gray-500 mb-6">Lihat dan kerjakan tugas dari dosen Anda</p>
<select id="filter" class="px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm mb-6" onchange="window.location='<?php echo e(route('mahasiswa.assignments')); ?>?matkul='+this.value">
    <option value="">Semua Mata Kuliah</option>
    <?php $__currentLoopData = $enrolled; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($m->id); ?>" <?php echo e($filterMatkul == $m->id ? 'selected' : ''); ?>><?php echo e($m->nama_makul); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
<div class="space-y-4">
    <?php $filtered = $filterMatkul ? $enrolled->where('id', $filterMatkul) : $enrolled; ?>
    <?php $__empty_1 = true; $__currentLoopData = $filtered; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php if($m->tugas->count() > 0): ?>
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="p-5 border-b border-gray-50"><h3 class="font-bold text-gray-900"><?php echo e($m->nama_makul); ?></h3></div>
            <div class="divide-y divide-gray-50">
                <?php $__currentLoopData = $m->tugas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $sub = $submissions->firstWhere('tugas_id', $t->id); ?>
                    <div class="p-5 hover:bg-gray-50/50 transition">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <p class="font-semibold"><?php echo e($t->nama_tugas); ?></p>
                                <p class="text-sm text-gray-500 mt-1"><?php echo e($t->deskripsi_tugas); ?></p>
                                <div class="flex flex-wrap gap-3 mt-3 text-xs text-gray-400">
                                    <span><i class="fas fa-calendar mr-1"></i>Deadline: <?php echo e($t->tanggal_akhir_deadline?->translatedFormat('j F Y') ?? '-'); ?></span>
                                    <span><i class="fas fa-star mr-1"></i>Maks: <?php echo e($t->max_nilai); ?></span>
                                    <?php if($t->file_tugas): ?>
                                        <a href="<?php echo e(asset('storage/' . $t->file_tugas)); ?>" target="_blank" class="text-cyan-600 font-semibold hover:underline"><i class="fas fa-file-download mr-1"></i>Unduh Soal/Template</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <?php if($sub): ?>
                                    <div class="flex flex-col items-end gap-1">
                                        <?php if($sub->nilai !== null): ?>
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-cyan-100 text-cyan-700">Dinilai: <?php echo e($sub->nilai); ?></span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Dikumpul</span>
                                        <?php endif; ?>
                                        <a href="<?php echo e(asset('storage/' . $sub->file_dikumpul)); ?>" target="_blank" class="text-[10px] text-cyan-600 hover:underline"><i class="fas fa-file-pdf mr-1"></i>Lihat file saya</a>
                                    </div>
                                <?php else: ?>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 mb-2 inline-block">Belum dikumpul</span>
                                    <form method="POST" action="<?php echo e(route('mahasiswa.assignments.submit')); ?>" enctype="multipart/form-data" class="flex flex-col items-end gap-2">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="tugas_id" value="<?php echo e($t->id); ?>">
                                        <input type="file" name="file" required accept=".pdf,.doc,.docx,.zip,.rar,.py,.ipynb,.xlsx,.html" class="max-w-[200px] text-xs file:mr-2 file:py-1 file:px-3 file:rounded-xl file:border-0 file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100">
                                        <button type="submit" class="px-4 py-2 bg-cyan-600 text-white rounded-lg text-xs font-medium hover:bg-cyan-700 transition"><i class="fas fa-upload mr-1"></i>Kumpul</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if($sub && $sub->feedback): ?>
                            <div class="mt-3 p-3 bg-cyan-50 rounded-xl text-sm text-cyan-700"><i class="fas fa-comment mr-1"></i><b>Feedback:</b> <?php echo e($sub->feedback); ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-center py-16 text-gray-400"><i class="fas fa-clipboard text-4xl mb-4"></i><p>Belum ada tugas</p></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', ['activePage' => 'assignments'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\polimicro\resources\views/mahasiswa/assignments.blade.php ENDPATH**/ ?>