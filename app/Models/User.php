<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'address',
        'nim', 'nip', 'bidang', 'status',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ---- ROLE HELPERS ----
    public function isMahasiswa(): bool { return $this->role === 'mahasiswa'; }
    public function isDosen(): bool { return $this->role === 'dosen'; }
    public function isAdminPic(): bool { return $this->role === 'admin_pic'; }
    public function isAdminAkademik(): bool { return $this->role === 'admin_akademik'; }

    public function getDashboardRoute(): string
    {
        return match ($this->role) {
            'mahasiswa' => 'mahasiswa.dashboard',
            'dosen' => 'dosen.dashboard',
            'admin_pic' => 'admin-pic.dashboard',
            'admin_akademik' => 'admin-akademik.dashboard',
            default => 'login',
        };
    }

    public function getRoleLabel(): string
    {
        return match ($this->role) {
            'mahasiswa' => 'Mahasiswa',
            'dosen' => 'Dosen',
            'admin_pic' => 'Admin PIC',
            'admin_akademik' => 'Admin Akademik',
            default => $this->role,
        };
    }

    public function getInitials(): string
    {
        return strtoupper(collect(explode(' ', $this->name))->map(fn($w) => $w[0] ?? '')->take(2)->join(''));
    }

    // ---- RELATIONSHIPS ----

    /** Dosen: mata kuliah yang diampu */
    public function matkulDiampu()
    {
        return $this->hasMany(Makul::class, 'dosen_id');
    }

    /** Mahasiswa: pendaftaran */
    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'mahasiswa_id');
    }

    /** Mahasiswa: pendaftaran diterima */
    public function enrolledProdi()
    {
        return $this->pendaftaran()->where('status', 'diterima');
    }

    /** Mahasiswa: submissions */
    public function submissions()
    {
        return $this->hasMany(PengerjaanTugas::class, 'mahasiswa_id');
    }

    /** Mahasiswa: sertifikat */
    public function sertifikat()
    {
        return $this->hasMany(Sertifikat::class, 'mahasiswa_id');
    }

    /** Get enrolled matkul for mahasiswa */
    public function getEnrolledMatkul()
    {
        $prodiIds = $this->enrolledProdi()->pluck('prodi_id');
        return Makul::whereIn('prodi_id', $prodiIds)->with(['prodi', 'dosen'])->get();
    }

    // ---- SCOPES ----
    public function scopeMahasiswa($query) { return $query->where('role', 'mahasiswa'); }
    public function scopeDosen($query) { return $query->where('role', 'dosen'); }
}
