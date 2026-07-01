<?php $__env->startSection('title', 'Kelola Dosen - Admin Akademik - Polimicro'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-6">
    <div><h1 class="text-2xl font-bold text-gray-900">Kelola Data Dosen</h1><p class="text-gray-500">Tambah, edit, atau hapus data dosen</p></div>
    <div class="flex gap-3">
        <a href="<?php echo e(route('admin-akademik.lecturers.export')); ?>" class="px-5 py-3 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-xl font-bold text-sm hover:bg-emerald-100 transition inline-flex items-center gap-2">
            <i class="fas fa-file-csv"></i> Export CSV
        </a>
        <button onclick="openDosenModal()" class="px-5 py-3 btn-primary text-white rounded-xl font-semibold text-sm"><i class="fas fa-plus mr-2"></i>Tambah Dosen</button>
    </div>
</div>
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto"><table class="w-full text-sm">
        <thead><tr class="bg-gray-50" style="background:#faf8f5"><th class="px-5 py-3 text-left font-semibold text-gray-600">Dosen</th><th class="px-5 py-3 text-left font-semibold text-gray-600">NIP</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Homebase</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Email</th><th class="px-5 py-3 text-center font-semibold text-gray-600">Matkul</th><th class="px-5 py-3 text-center font-semibold text-gray-600">Aksi</th></tr></thead>
        <tbody class="divide-y divide-gray-50">
        <?php $__currentLoopData = $dosenList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $mc = \App\Models\Makul::where('dosen_id', $d->id)->count(); ?>
            <tr class="hover:bg-slate-50 group/row transition">
                <td class="px-5 py-4"><div class="flex items-center gap-3"><div class="w-10 h-10 rounded-full bg-cyan-600 flex items-center justify-center text-white text-xs font-bold transition-transform group-hover/row:scale-110 shadow-lg shadow-cyan-600/20"><?php echo e($d->getInitials()); ?></div><div><p class="font-medium text-slate-800"><?php echo e($d->name); ?></p><p class="text-xs text-slate-400"><?php echo e($d->phone ?? ''); ?></p></div></div></td>
                <td class="px-5 py-4 text-slate-500 font-mono text-xs"><?php echo e($d->nip ?? '-'); ?></td>
                <td class="px-5 py-4 text-slate-500 text-xs">
                    <?php if($d->homebase): ?>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-cyan-50 text-cyan-700 font-bold border border-cyan-100">
                            <i class="fas fa-university text-[10px]"></i><?php echo e($d->homebase); ?>

                        </span>
                    <?php else: ?>
                        <span class="text-slate-300">—</span>
                    <?php endif; ?>
                </td>
                <td class="px-5 py-4 text-slate-500 text-xs"><?php echo e($d->email); ?></td>
                <td class="px-5 py-4 text-center"><span class="px-3 py-1 rounded-full text-xs font-bold bg-cyan-100 text-cyan-700 border border-cyan-100"><?php echo e($mc); ?></span></td>
                <td class="px-5 py-4 text-center">
                    <div class="row-actions flex gap-2 justify-center">
                        <button onclick="editDosen(<?php echo e($d->id); ?>,'<?php echo e(addslashes($d->name)); ?>','<?php echo e($d->email); ?>','<?php echo e($d->nip); ?>','<?php echo e($d->phone); ?>','<?php echo e(addslashes($d->homebase ?? '')); ?>','<?php echo e(addslashes($d->address ?? '')); ?>')" class="px-3 py-2 bg-cyan-50 text-cyan-600 rounded-lg text-xs hover:bg-cyan-100 transition border border-cyan-100"><i class="fas fa-edit"></i></button>
                        <form method="POST" action="<?php echo e(route('admin-akademik.lecturers.destroy', $d)); ?>">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="button" onclick="confirmDelete(this)" class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-xs hover:bg-red-100 transition border border-red-100"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table></div>
</div>

<div class="mt-6">
    <?php echo e($dosenList->links()); ?>

</div>

<?php $__env->startPush('modals'); ?>

<div id="dosen-modal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background:rgba(15,23,42,0.6); backdrop-filter: blur(4px);">
    <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-lg w-full mx-4 fade-in">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold font-serif text-slate-800" id="dm-title">Tambah Dosen</h3>
            <button type="button" onclick="closeDosenModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 transition"><i class="fas fa-times text-sm"></i></button>
        </div>
        <form id="dosen-form" method="POST" action="<?php echo e(route('admin-akademik.lecturers.store')); ?>" class="space-y-4" onsubmit="disableSubmit(this)"><?php echo csrf_field(); ?> <span id="dosen-method"></span>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Nama Lengkap <span class="text-red-400">*</span></label><input type="text" name="name" id="df-nama" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 transition outline-none" placeholder="Masukkan nama lengkap"></div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-600 mb-1">Email <span class="text-red-400">*</span></label><input type="email" name="email" id="df-email" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 transition outline-none" placeholder="email@example.com"></div>
                <div><label class="block text-sm font-medium text-slate-600 mb-1">NIP</label><input type="text" name="nip" id="df-nip" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 transition outline-none" placeholder="Nomor Induk Pegawai"></div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-600 mb-1">No. Telepon</label><input type="tel" name="phone" id="df-phone" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 transition outline-none" placeholder="08xxxxxxxxxx"></div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Homebase</label>
                    <select name="homebase" id="df-homebase" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 transition bg-white appearance-none outline-none" style="background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%239ca3af%22 stroke-width=%222%22%3E%3Cpath d=%22M6 9l6 6 6-6%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 12px center; background-size: 16px;">
                        <option value="">— Pilih Homebase —</option>
                        <?php $__currentLoopData = $prodiList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prodi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($prodi->nama_prodi); ?>"><?php echo e($prodi->nama_prodi); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Alamat</label><textarea name="address" id="df-address" rows="2" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 transition resize-none outline-none" placeholder="Alamat lengkap dosen"></textarea></div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeDosenModal()" class="flex-1 py-3 rounded-xl border border-slate-200 text-slate-600 font-medium hover:bg-slate-50 transition">Batal</button>
                <button type="submit" id="btn-submit-dosen" class="flex-1 py-3 bg-cyan-600 text-white hover:bg-cyan-700 rounded-xl font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-cyan-600/20">
                    <i class="fas fa-save text-sm"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function openDosenModal() {
    document.getElementById('dm-title').textContent = 'Tambah Dosen';
    document.getElementById('dosen-form').action = '<?php echo e(route('admin-akademik.lecturers.store')); ?>';
    document.getElementById('dosen-method').innerHTML = '';
    ['df-nama','df-email','df-nip','df-phone','df-address'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('df-homebase').value = '';
    resetSubmitBtn();
    document.getElementById('dosen-modal').classList.remove('hidden');
    document.getElementById('dosen-modal').classList.add('flex');
}

function editDosen(id, nama, email, nip, phone, homebase, address) {
    document.getElementById('dm-title').textContent = 'Edit Dosen';
    document.getElementById('dosen-form').action = '/admin-akademik/lecturers/' + id;
    document.getElementById('dosen-method').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('df-nama').value = nama;
    document.getElementById('df-email').value = email;
    document.getElementById('df-nip').value = nip;
    document.getElementById('df-phone').value = phone;
    document.getElementById('df-homebase').value = homebase;
    document.getElementById('df-address').value = address;
    resetSubmitBtn();
    document.getElementById('dosen-modal').classList.remove('hidden');
    document.getElementById('dosen-modal').classList.add('flex');
}

function closeDosenModal() {
    document.getElementById('dosen-modal').classList.add('hidden');
    document.getElementById('dosen-modal').classList.remove('flex');
}

function disableSubmit(form) {
    const btn = document.getElementById('btn-submit-dosen');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin text-sm"></i> Menyimpan...';
}

function resetSubmitBtn() {
    const btn = document.getElementById('btn-submit-dosen');
    btn.disabled = false;
    btn.innerHTML = '<i class="fas fa-save text-sm"></i> Simpan';
}

// Close modal on backdrop click
document.getElementById('dosen-modal').addEventListener('click', function(e) {
    if (e.target === this) closeDosenModal();
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDosenModal();
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', ['activePage' => 'lecturers'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\polimicro\resources\views/admin-akademik/lecturers.blade.php ENDPATH**/ ?>