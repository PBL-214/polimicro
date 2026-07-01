<?php $__env->startSection('title', 'Kelola Mata Kuliah - Admin PIC - Polimicro'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-6">
    <div><h1 class="text-2xl font-bold text-gray-900">Kelola Mata Kuliah</h1><p class="text-gray-500">Kelola mata kuliah per program studi</p></div>
<button onclick="openMKModal()" class="px-5 py-3 bg-cyan-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-cyan-600/20 hover:bg-cyan-700 transition"><i class="fas fa-plus mr-2"></i>Tambah Matkul</button>
</div>
<div class="flex gap-4 mb-8">
    <select class="px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm focus:ring-4 focus:ring-cyan-500/10 outline-none transition" onchange="window.location='<?php echo e(route('admin-pic.courses')); ?>?prodi='+this.value">
        <option value="all">Semua Program Studi</option>
        <?php $__currentLoopData = $prodiList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($p->id); ?>" <?php echo e($filter == $p->id ? 'selected' : ''); ?>><?php echo e($p->nama_prodi); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>
<div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm">
    <div class="overflow-x-auto"><table class="w-full text-sm">
        <thead><tr class="bg-slate-50/50 border-b border-slate-100"><th class="px-5 py-4 text-left font-bold text-slate-600 uppercase tracking-wider text-[10px]">Mata Kuliah</th><th class="px-5 py-4 text-left font-bold text-slate-600 uppercase tracking-wider text-[10px]">Program Studi</th><th class="px-5 py-4 text-left font-bold text-slate-600 uppercase tracking-wider text-[10px]">Dosen Pengampu</th><th class="px-5 py-4 text-center font-bold text-slate-600 uppercase tracking-wider text-[10px]">SKS</th><th class="px-5 py-4 text-center font-bold text-slate-600 uppercase tracking-wider text-[10px]">Aksi</th></tr></thead>
        <tbody class="divide-y divide-slate-50">
        <?php $__empty_1 = true; $__currentLoopData = $matkuls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-slate-50/80 transition group">
                <td class="px-5 py-4">
                    <p class="font-bold text-slate-800 text-sm group-hover:text-cyan-600 transition"><?php echo e($m->nama_makul); ?></p>
                    <p class="text-[10px] text-slate-400 mt-1 max-w-xs truncate font-medium"><?php echo e($m->deskripsi ?: 'No description provided.'); ?></p>
                </td>
                <td class="px-5 py-4"><span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 text-[10px] font-bold uppercase tracking-tighter"><?php echo e($m->prodi->nama_prodi ?? '-'); ?></span></td>
                <td class="px-5 py-4">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full bg-cyan-50 flex items-center justify-center text-[8px] font-bold text-cyan-600 border border-cyan-100"><?php echo e($m->dosen ? $m->dosen->getInitials() : '?'); ?></div>
                        <span class="text-slate-500 text-xs font-medium"><?php echo e($m->dosen->name ?? '-'); ?></span>
                    </div>
                </td>
                <td class="px-5 py-4 text-center font-bold text-slate-700"><?php echo e($m->sks); ?></td>
                <td class="px-5 py-4 text-center">
                    <div class="row-actions flex gap-2 justify-center">
                        <button onclick="editMK(<?php echo e($m->id); ?>,'<?php echo e(addslashes($m->nama_makul)); ?>',<?php echo e($m->prodi_id); ?>,<?php echo e($m->dosen_id); ?>,'<?php echo e(addslashes($m->deskripsi)); ?>',<?php echo e($m->sks); ?>)" class="px-3 py-2 bg-cyan-50 text-cyan-600 rounded-lg text-xs hover:bg-cyan-100 transition border border-cyan-100"><i class="fas fa-edit"></i></button>
                        <form method="POST" action="<?php echo e(route('admin-pic.courses.destroy', $m)); ?>">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="button" onclick="confirmDelete(this)" class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-xs hover:bg-red-100 transition border border-red-100"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="5" class="px-5 py-16 text-center text-slate-300"><i class="fas fa-book text-5xl mb-4 block opacity-20"></i><p class="font-bold">Tidak ada data mata kuliah</p></td></tr>
        <?php endif; ?>
        </tbody>
    </table></div>
</div>

<div class="mt-6">
    <?php echo e($matkuls->withQueryString()->links()); ?>

</div>

<?php $__env->startPush('modals'); ?>
<div id="mk-modal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background:rgba(15,23,42,0.6); backdrop-filter: blur(4px);">
    <div class="bg-white rounded-[2.5rem] shadow-2xl p-10 max-w-lg w-full mx-4 fade-in">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-bold font-serif text-slate-800" id="mkm-title">Tambah Matkul</h3>
            <button type="button" onclick="closeMKModal()" class="w-10 h-10 rounded-full bg-slate-50 hover:bg-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-600 transition"><i class="fas fa-times text-sm"></i></button>
        </div>
        <form id="mk-form" method="POST" action="<?php echo e(route('admin-pic.courses.store')); ?>" class="space-y-5" onsubmit="this.querySelector('[data-submit]').disabled=true;this.querySelector('[data-submit]').innerHTML='<i class=\'fas fa-spinner fa-spin text-sm\'></i> Menyimpan...'"><?php echo csrf_field(); ?> <span id="mk-method"></span>
            <div><label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Nama Mata Kuliah <span class="text-red-400">*</span></label><input type="text" name="nama_makul" id="mkf-nama" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 outline-none transition"></div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Program Studi <span class="text-red-400">*</span></label><select name="prodi_id" id="mkf-prodi" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 outline-none transition"><?php $__currentLoopData = $prodiList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($p->id); ?>"><?php echo e($p->nama_prodi); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
                <div><label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Dosen Pengampu <span class="text-red-400">*</span></label><select name="dosen_id" id="mkf-dosen" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 outline-none transition"><?php $__currentLoopData = $dosenList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($d->id); ?>"><?php echo e($d->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
            </div>
            <div><label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Deskripsi</label><textarea name="deskripsi" id="mkf-desc" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 outline-none transition"></textarea></div>
            <div><label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">SKS (1-6)</label><input type="number" name="sks" id="mkf-sks" value="3" min="1" max="6" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 outline-none transition"></div>
            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeMKModal()" class="flex-1 py-3.5 rounded-xl border border-slate-100 text-slate-500 font-bold text-xs hover:bg-slate-50 transition">BATAL</button>
                <button type="submit" data-submit class="flex-1 py-3.5 bg-cyan-600 text-white hover:bg-cyan-700 rounded-xl font-bold text-xs transition flex items-center justify-center gap-2 shadow-lg shadow-cyan-600/20"><i class="fas fa-save text-sm"></i> SIMPAN</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function openMKModal() {
    document.getElementById('mkm-title').textContent='Tambah Mata Kuliah';
    document.getElementById('mk-form').action='<?php echo e(route('admin-pic.courses.store')); ?>';
    document.getElementById('mk-method').innerHTML='';
    ['mkf-nama','mkf-desc'].forEach(id => document.getElementById(id).value='');
    document.getElementById('mkf-sks').value=3;
    document.getElementById('mk-modal').classList.remove('hidden');
    document.getElementById('mk-modal').classList.add('flex');
}
function editMK(id,nama,prodi,dosen,desc,sks) {
    document.getElementById('mkm-title').textContent='Edit Mata Kuliah';
    document.getElementById('mk-form').action='/admin-pic/courses/'+id;
    document.getElementById('mk-method').innerHTML='<input type="hidden" name="_method" value="PUT">';
    document.getElementById('mkf-nama').value=nama;
    document.getElementById('mkf-prodi').value=prodi;
    document.getElementById('mkf-dosen').value=dosen;
    document.getElementById('mkf-desc').value=desc;
    document.getElementById('mkf-sks').value=sks;
    document.getElementById('mk-modal').classList.remove('hidden');
    document.getElementById('mk-modal').classList.add('flex');
}
function closeMKModal() { document.getElementById('mk-modal').classList.add('hidden'); document.getElementById('mk-modal').classList.remove('flex'); }
document.getElementById('mk-modal').addEventListener('click', function(e) { if (e.target === this) closeMKModal(); });
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeMKModal(); });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', ['activePage' => 'courses'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\polimicro\resources\views/admin-pic/courses.blade.php ENDPATH**/ ?>