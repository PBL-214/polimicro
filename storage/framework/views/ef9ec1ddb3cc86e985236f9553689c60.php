<?php $__env->startSection('title', 'Pengumpulan Tugas - Dosen - Polimicro'); ?>
<?php $__env->startSection('content'); ?>
<h1 class="text-2xl font-bold text-gray-900 mb-2">Pengumpulan Tugas</h1>
<p class="text-gray-500 mb-6">Lihat dan nilai tugas yang dikumpulkan mahasiswa</p>
<select class="px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm mb-6" onchange="window.location='<?php echo e(route('dosen.submissions')); ?>?tugas='+this.value">
    <option value="">Semua Tugas</option>
    <?php $__currentLoopData = $allTugas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($t->id); ?>" <?php echo e($filterTugas == $t->id ? 'selected' : ''); ?>><?php echo e($t->nama_tugas); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</select>
<?php $filtered = $filterTugas ? $allTugas->where('id', $filterTugas) : $allTugas; ?>
<?php $__currentLoopData = $filtered; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php $subs = $t->submissions()->with('mahasiswa')->get(); ?>
    <?php if($subs->count() > 0): ?>
    <div class="bg-white rounded-2xl border border-gray-100 mb-4 overflow-hidden">
        <div class="p-5 border-b border-gray-50"><h3 class="font-bold"><?php echo e($t->nama_tugas); ?></h3><p class="text-xs text-gray-400"><?php echo e($t->makul->nama_makul ?? ''); ?> • Deadline: <?php echo e($t->tanggal_akhir_deadline?->format('d/m/Y') ?? '-'); ?></p></div>
        <div class="overflow-x-auto"><table class="w-full text-sm">
            <thead><tr class="bg-gray-50" style="background:#faf8f5"><th class="px-5 py-3 text-left font-semibold text-gray-600">Mahasiswa</th><th class="px-5 py-3 text-left font-semibold text-gray-600">File</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Tanggal</th><th class="px-5 py-3 text-center font-semibold text-gray-600">Nilai</th><th class="px-5 py-3 text-center font-semibold text-gray-600">Aksi</th></tr></thead>
            <tbody class="divide-y divide-gray-50">
            <?php $__currentLoopData = $subs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-4"><div class="flex items-center gap-3"><div class="w-8 h-8 rounded-full bg-cyan-100 flex items-center justify-center text-xs font-bold text-cyan-700"><?php echo e($s->mahasiswa ? $s->mahasiswa->getInitials() : '?'); ?></div><div><p class="font-medium"><?php echo e($s->mahasiswa->name ?? '-'); ?></p><p class="text-xs text-gray-400"><?php echo e($s->mahasiswa->nim ?? ''); ?></p></div></div></td>
                    <td class="px-5 py-4 text-gray-500 text-xs">
                        <?php if($s->file_dikumpul): ?>
                            <a href="<?php echo e(asset('storage/' . $s->file_dikumpul)); ?>" target="_blank" class="text-cyan-600 hover:text-cyan-700 font-semibold"><i class="fas fa-download mr-1"></i>Unduh</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-4 text-gray-400 text-xs"><?php echo e($s->waktu_kumpul?->format('d/m/Y H:i') ?? '-'); ?></td>
                    <td class="px-5 py-4 text-center font-bold"><?php echo e($s->nilai !== null ? $s->nilai : '-'); ?></td>
                    <td class="px-5 py-4 text-center"><button onclick="openGrade(<?php echo e($s->id); ?>,'<?php echo e($s->mahasiswa->name ?? '-'); ?>','<?php echo e($t->nama_tugas); ?>',<?php echo e($s->nilai ?? 'null'); ?>,'<?php echo e($s->feedback ?? ''); ?>')" class="px-4 py-2 bg-cyan-50 text-cyan-600 rounded-lg text-xs hover:bg-cyan-100 font-medium"><i class="fas fa-pen mr-1"></i><?php echo e($s->nilai !== null ? 'Edit' : 'Nilai'); ?></button></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table></div>
    </div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->startPush('modals'); ?>
<div id="grade-modal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background:rgba(15,23,42,0.6); backdrop-filter: blur(4px);">
    <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full mx-4 fade-in">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold font-serif text-slate-800">Beri Nilai</h3>
            <button type="button" onclick="closeGradeModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 transition"><i class="fas fa-times text-sm"></i></button>
        </div>
        <form id="grade-form" method="POST" class="space-y-4" onsubmit="this.querySelector('[data-submit]').disabled=true;this.querySelector('[data-submit]').innerHTML='<i class=\'fas fa-spinner fa-spin text-sm\'></i> Menyimpan...'"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <p class="text-sm text-slate-600 font-semibold bg-slate-50 px-4 py-3 rounded-xl" id="gf-info"></p>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Nilai (0-100) <span class="text-red-400">*</span></label><input type="number" name="nilai" id="gf-nilai" min="0" max="100" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></div>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Feedback</label><textarea name="feedback" id="gf-feedback" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></textarea></div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeGradeModal()" class="flex-1 py-3 rounded-xl border border-slate-200 text-slate-600 font-medium hover:bg-slate-50 transition">Batal</button>
                <button type="submit" data-submit class="flex-1 py-3 bg-cyan-600 text-white hover:bg-cyan-700 rounded-xl font-semibold transition flex items-center justify-center gap-2"><i class="fas fa-save text-sm"></i> Simpan Nilai</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
function openGrade(id, mhs, tugas, nilai, feedback) {
    document.getElementById('grade-form').action = '/dosen/submissions/' + id + '/grade';
    document.getElementById('gf-info').textContent = mhs + ' — ' + tugas;
    document.getElementById('gf-nilai').value = nilai || '';
    document.getElementById('gf-feedback').value = feedback || '';
    const btn = document.querySelector('#grade-form [data-submit]');
    btn.disabled = false;
    btn.innerHTML = '<i class="fas fa-save text-sm"></i> Simpan Nilai';
    document.getElementById('grade-modal').classList.remove('hidden');
    document.getElementById('grade-modal').classList.add('flex');
}
function closeGradeModal() { document.getElementById('grade-modal').classList.add('hidden'); document.getElementById('grade-modal').classList.remove('flex'); }
document.getElementById('grade-modal').addEventListener('click', function(e) { if (e.target === this) closeGradeModal(); });
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeGradeModal(); });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', ['activePage' => 'submissions'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\polimicro\resources\views/dosen/submissions.blade.php ENDPATH**/ ?>