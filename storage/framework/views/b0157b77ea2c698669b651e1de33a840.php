<?php $__env->startSection('title', 'Dashboard Admin Akademik - Polimicro'); ?>
<?php $__env->startSection('content'); ?>
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 font-serif">Pusat Data Akademik</h1>
        <p class="text-gray-500 mt-1">Kelola data dosen, program studi, dan penerbitan sertifikat</p>
    </div>
    <div class="flex gap-2">
        <a href="<?php echo e(route('admin-akademik.lecturers')); ?>" class="px-5 py-3 bg-white text-slate-800 border border-slate-200 rounded-xl font-bold text-sm hover:border-cyan-300 hover:text-cyan-600 transition"><i class="fas fa-user-plus mr-2"></i>Dosen</a>
        <a href="<?php echo e(route('admin-akademik.programs')); ?>" class="px-5 py-3 bg-slate-900 text-white rounded-xl font-bold text-sm hover:bg-black transition shadow-lg shadow-black/10"><i class="fas fa-university mr-2"></i>Kelola Prodi</a>
    </div>
</div>

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-3xl p-6 border border-gray-100 card-hover">
        <div class="w-12 h-12 rounded-2xl bg-cyan-50 flex items-center justify-center text-cyan-600 mb-4 shadow-sm border border-cyan-100"><i class="fas fa-chalkboard-teacher"></i></div>
        <p class="text-3xl font-bold text-gray-900"><?php echo e($totalDosen); ?></p>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mt-1">Total Dosen</p>
    </div>
    <div class="bg-white rounded-3xl p-6 border border-gray-100 card-hover">
        <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 mb-4 shadow-sm border border-blue-100"><i class="fas fa-university"></i></div>
        <p class="text-3xl font-bold text-gray-900"><?php echo e($totalProdi); ?></p>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mt-1">Program Studi</p>
    </div>
    <div class="bg-white rounded-3xl p-6 border border-gray-100 card-hover">
        <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 mb-4 shadow-sm border border-amber-100"><i class="fas fa-certificate"></i></div>
        <p class="text-3xl font-bold text-gray-900"><?php echo e($totalCerts); ?></p>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mt-1">Sertifikat Terbit</p>
    </div>
    <div class="bg-white rounded-3xl p-6 border border-gray-100 card-hover">
        <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600 mb-4 shadow-sm border border-purple-100"><i class="fas fa-users"></i></div>
        <p class="text-3xl font-bold text-gray-900"><?php echo e($totalMhs); ?></p>
        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider mt-1">Total Mahasiswa</p>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-8">
    
    <div class="bg-white rounded-3xl border border-gray-100 p-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6 font-serif">Distribusi Mahasiswa</h2>
        <div class="h-64 flex items-center justify-center">
            <canvas id="chart1"></canvas>
        </div>
    </div>

    
    <div class="bg-white rounded-3xl border border-gray-100 p-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900 font-serif">Daftar Dosen</h2>
            <a href="<?php echo e(route('admin-akademik.lecturers')); ?>" class="text-xs font-bold text-cyan-600 hover:underline">Lihat Semua</a>
        </div>
        <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
            <?php $__empty_1 = true; $__currentLoopData = $dosenList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php $mc = \App\Models\Makul::where('dosen_id', $d->id)->count(); ?>
                <div class="flex items-center gap-4 p-4 rounded-2xl bg-gray-50 border border-transparent hover:border-cyan-100 hover:bg-white transition duration-300">
                    <div class="w-10 h-10 rounded-full gradient-primary flex items-center justify-center text-white text-xs font-bold shadow-md"><?php echo e($d->getInitials()); ?></div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-gray-900"><?php echo e($d->name); ?></p>
                        <p class="text-[11px] text-gray-400 mt-0.5"><?php echo e($d->homebase ?? 'Homebase'); ?></p>
                    </div>
                    <span class="text-[10px] font-bold text-cyan-600 bg-cyan-50 px-2 py-1 rounded-lg"><?php echo e($mc); ?> Matkul</span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-center text-gray-400 py-8">Belum ada data dosen</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?><script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script><?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
const ctx = document.getElementById('chart1');
new Chart(ctx, {
    type: 'doughnut',
    data: { 
        labels: <?php echo json_encode($prodiList->pluck('nama_prodi'), 15, 512) ?>, 
        datasets: [{ 
            data: <?php echo json_encode($prodiList->map(fn($p) => $p->pendaftaranDiterima()->count()), 15, 512) ?>, 
            backgroundColor: ['#0891B2','#06B6D4','#22D3EE','#0E7490','#164E63'], 
            borderWidth: 0,
            hoverOffset: 15
        }] 
    },
    options: { 
        maintainAspectRatio: false,
        responsive: true, 
        plugins: { 
            legend: { 
                position: 'bottom', 
                labels: { 
                    usePointStyle: true, 
                    padding: 15,
                    font: { family: 'Plus Jakarta Sans', size: 10, weight: '600' }
                } 
            } 
        },
        cutout: '65%'
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', ['activePage' => 'dashboard'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\polimicro\resources\views/admin-akademik/dashboard.blade.php ENDPATH**/ ?>