<?php $__env->startSection('title', 'Sertifikat - Polimicro'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold text-slate-900 mb-2 font-serif">Sertifikat Saya</h1>
<p class="text-slate-500 mb-6">Download sertifikat kelulusan program</p>
<div class="grid md:grid-cols-2 gap-6">
    <?php $__empty_1 = true; $__currentLoopData = $certs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden card-hover shadow-sm">
            <div class="bg-slate-50 p-6 text-center border-b border-slate-100">
                <div class="w-16 h-16 mx-auto rounded-full bg-white shadow-sm flex items-center justify-center mb-3"><i class="fas fa-award text-cyan-600 text-2xl"></i></div>
                <h3 class="font-bold text-slate-800 text-lg font-serif">Sertifikat Kelulusan</h3>
                <p class="text-slate-600 font-medium"><?php echo e($c->prodi->nama_prodi ?? '-'); ?></p>
            </div>
            <div class="p-6">
                <div class="space-y-3 text-sm mb-6">
                    <div class="flex justify-between"><span class="text-slate-500">Nomor</span><span class="font-medium font-mono text-xs text-slate-700"><?php echo e($c->nomor_sertifikat); ?></span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Tanggal Terbit</span><span class="font-medium text-slate-700"><?php echo e($c->tanggal_terbit->format('d/m/Y')); ?></span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Status</span><span class="px-3 py-1 rounded-full text-xs font-semibold bg-cyan-50 text-cyan-700"><?php echo e(ucfirst($c->status)); ?></span></div>
                </div>
                <?php if($c->file_sertifikat): ?>
                    <a href="<?php echo e(asset('storage/' . $c->file_sertifikat)); ?>" target="_blank" class="block w-full py-3 text-center bg-cyan-600 hover:bg-cyan-700 text-white rounded-xl font-semibold transition"><i class="fas fa-download mr-2"></i>Unduh Sertifikat</a>
                <?php else: ?>
                    <button disabled class="w-full py-3 bg-slate-100 text-slate-400 rounded-xl font-semibold cursor-not-allowed"><i class="fas fa-clock mr-2"></i>File Belum Tersedia</button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-full text-center py-16 bg-white rounded-2xl border border-slate-100 shadow-sm"><i class="fas fa-certificate text-4xl text-slate-300 mb-4 block"></i><p class="text-slate-500">Belum ada sertifikat.</p></div>
    <?php endif; ?>
</div>

<div class="mt-8">
    <?php echo e($certs->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', ['activePage' => 'certificates'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\polimicro\resources\views/mahasiswa/certificates.blade.php ENDPATH**/ ?>