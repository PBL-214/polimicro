<?php $__env->startSection('title', 'Data Pelajar - Admin PIC - Polimicro'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold text-gray-900 mb-2">Data Pelajar</h1>
<p class="text-gray-500 mb-6">Kelola data mahasiswa per program studi</p>
<div class="flex flex-wrap gap-4 mb-6">
    <select class="px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm" onchange="let p=this.value;let s=document.getElementById('search-box').value;window.location='<?php echo e(route('admin-pic.students')); ?>?prodi='+p+'&search='+s">
        <option value="all">Semua Prodi</option>
        <?php $__currentLoopData = $prodiList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($p->id); ?>" <?php echo e($prodiFilter == $p->id ? 'selected' : ''); ?>><?php echo e($p->nama_prodi); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
    <form class="relative flex-1 min-w-[200px]"><i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
        <input type="text" name="search" id="search-box" placeholder="Cari mahasiswa..." value="<?php echo e($search); ?>" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 bg-white text-sm">
        <?php if($prodiFilter): ?><input type="hidden" name="prodi" value="<?php echo e($prodiFilter); ?>"><?php endif; ?>
    </form>
    <a href="<?php echo e(route('admin-pic.students.export')); ?>" class="px-5 py-3 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-xl font-bold text-sm hover:bg-emerald-100 transition inline-flex items-center gap-2">
        <i class="fas fa-file-csv"></i> Export CSV
    </a>
</div>
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="p-5 border-b border-gray-50 flex justify-between"><span class="font-bold text-gray-900">Daftar Mahasiswa</span><span class="text-sm text-gray-400">Total: <?php echo e($students->total()); ?></span></div>
    <div class="overflow-x-auto"><table class="w-full text-sm">
        <thead><tr class="bg-gray-50" style="background:#faf8f5"><th class="px-5 py-3 text-left font-semibold text-gray-600">Nama</th><th class="px-5 py-3 text-left font-semibold text-gray-600">NIM</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Email</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Telepon</th><th class="px-5 py-3 text-center font-semibold text-gray-600">Status</th></tr></thead>
        <tbody class="divide-y divide-gray-50">
        <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-slate-50 group transition">
                <td class="px-5 py-4"><div class="flex items-center gap-3"><div class="w-8 h-8 rounded-full bg-cyan-100 flex items-center justify-center text-xs font-bold text-cyan-700 transition-transform group-hover:scale-110 border border-white shadow-sm"><?php echo e($s->getInitials()); ?></div><span class="font-medium"><?php echo e($s->name); ?></span></div></td>
                <td class="px-5 py-4 text-gray-500 font-mono text-xs"><?php echo e($s->nim ?? '-'); ?></td>
                <td class="px-5 py-4 text-gray-500 text-xs"><?php echo e($s->email); ?></td>
                <td class="px-5 py-4 text-gray-400 text-xs"><?php echo e($s->phone ?? '-'); ?></td>
                <td class="px-5 py-4 text-center"><span class="px-3 py-1 rounded-full text-xs font-semibold <?php echo e($s->status === 'aktif' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-amber-50 text-amber-700 border border-amber-100'); ?>"><?php echo e(ucfirst($s->status)); ?></span></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="5" class="px-5 py-12 text-center text-gray-400">Tidak ada data</td></tr>
        <?php endif; ?>
        </tbody>
    </table></div>
</div>

<div class="mt-6">
    <?php echo e($students->withQueryString()->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', ['activePage' => 'students'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\polimicro\resources\views/admin-pic/students.blade.php ENDPATH**/ ?>