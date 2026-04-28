// POLIMICRO - Utilities
const Utils = {
  formatDate(d) {
    if (!d) return '-';
    const dt = new Date(d);
    return dt.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
  },
  formatShortDate(d) {
    if (!d) return '-';
    return new Date(d).toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
  },
  showToast(msg, type = 'success') {
    const t = document.createElement('div');
    const colors = { success: 'bg-green-500', error: 'bg-red-500', warning: 'bg-yellow-500', info: 'bg-blue-500' };
    t.className = `fixed top-6 right-6 z-[9999] px-6 py-3 rounded-xl text-white ${colors[type] || colors.info} shadow-2xl transform transition-all duration-500 translate-x-full`;
    t.innerHTML = `<div class="flex items-center gap-3"><span>${msg}</span></div>`;
    document.body.appendChild(t);
    requestAnimationFrame(() => t.classList.remove('translate-x-full'));
    setTimeout(() => { t.classList.add('translate-x-full'); setTimeout(() => t.remove(), 500); }, 3000);
  },
  getInitials(name) {
    return name.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
  },
  generateId(arr) {
    return arr.length > 0 ? Math.max(...arr.map(i => i.id)) + 1 : 1;
  },
  statusBadge(status) {
    const map = {
      aktif: 'bg-green-100 text-green-700', pending: 'bg-yellow-100 text-yellow-700',
      diterima: 'bg-green-100 text-green-700', ditolak: 'bg-red-100 text-red-700',
      nonaktif: 'bg-gray-100 text-gray-500', diterbitkan: 'bg-blue-100 text-blue-700'
    };
    return `<span class="px-3 py-1 rounded-full text-xs font-semibold ${map[status] || 'bg-gray-100 text-gray-600'}">${status.charAt(0).toUpperCase() + status.slice(1)}</span>`;
  }
};
