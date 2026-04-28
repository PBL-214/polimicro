// ============================================
// POLIMICRO - Authentication Module
// ============================================

const Auth = {
  SESSION_KEY: 'polimicro_session',

  login(email, password) {
    const user = PoliData.users.find(u => u.email === email && u.password === password);
    if (user) {
      const session = { id: user.id, nama: user.nama, email: user.email, role: user.role, loginAt: new Date().toISOString() };
      localStorage.setItem(this.SESSION_KEY, JSON.stringify(session));
      return { success: true, user: session };
    }
    return { success: false, message: 'Email atau password salah!' };
  },

  logout() {
    localStorage.removeItem(this.SESSION_KEY);
    window.location.href = this.getBasePath() + 'login.html';
  },

  getSession() {
    const s = localStorage.getItem(this.SESSION_KEY);
    return s ? JSON.parse(s) : null;
  },

  getCurrentUser() {
    const s = this.getSession();
    return s ? PoliData.getUserById(s.id) : null;
  },

  isLoggedIn() { return this.getSession() !== null; },

  requireAuth(allowedRoles = []) {
    const s = this.getSession();
    if (!s) { window.location.href = this.getBasePath() + 'login.html'; return false; }
    if (allowedRoles.length > 0 && !allowedRoles.includes(s.role)) {
      window.location.href = this.getBasePath() + this.getDashboardPath(s.role);
      return false;
    }
    return true;
  },

  getDashboardPath(role) {
    const map = { mahasiswa: 'student/dashboard.html', dosen: 'dosen/dashboard.html', admin_pic: 'admin-pic/dashboard.html', admin_akademik: 'admin-akademik/dashboard.html' };
    return map[role] || 'login.html';
  },

  getRoleLabel(role) {
    const map = { mahasiswa: 'Mahasiswa', dosen: 'Dosen', admin_pic: 'Admin PIC', admin_akademik: 'Admin Akademik' };
    return map[role] || role;
  },

  getBasePath() {
    const p = window.location.pathname;
    return (p.includes('/student/') || p.includes('/dosen/') || p.includes('/admin-pic/') || p.includes('/admin-akademik/')) ? '../' : '';
  },

  register(data) {
    if (PoliData.users.find(u => u.email === data.email)) return { success: false, message: 'Email sudah terdaftar!' };
    const newId = Math.max(...PoliData.users.map(u => u.id)) + 1;
    const newUser = { id: newId, nama: data.nama, email: data.email, password: data.password, role: 'mahasiswa', phone: data.phone || '', address: data.address || '', avatar: null, nim: '2024' + String(newId).padStart(3, '0'), status: 'pending' };
    PoliData.users.push(newUser);
    saveData();
    return { success: true, user: newUser };
  },

  resetPassword(email) {
    return PoliData.users.find(u => u.email === email) ? { success: true, message: 'Link reset password telah dikirim ke email Anda.' } : { success: false, message: 'Email tidak ditemukan!' };
  },

  updateProfile(userId, data) {
    const i = PoliData.users.findIndex(u => u.id === userId);
    if (i !== -1) { Object.assign(PoliData.users[i], data); saveData(); return { success: true }; }
    return { success: false, message: 'User tidak ditemukan!' };
  },

  changePassword(userId, oldPw, newPw) {
    const u = PoliData.getUserById(userId);
    if (!u) return { success: false, message: 'User tidak ditemukan!' };
    if (u.password !== oldPw) return { success: false, message: 'Password lama salah!' };
    u.password = newPw; saveData();
    return { success: true, message: 'Password berhasil diubah!' };
  }
};
