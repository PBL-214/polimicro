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
        'nim', 'nip', 'homebase',
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
    public function getMaxActiveDate()
    {
        $maxDate = null;
        $enrolled = $this->enrolledProdi()->with('prodi')->get();
        foreach ($enrolled as $pendaftaran) {
            $prodi = $pendaftaran->prodi;
            if (!$prodi) continue;
            
            $registeredAt = \Carbon\Carbon::parse($pendaftaran->registered_at);
            
            // Parse "6 Bulan", "1 Tahun"
            $durasiStr = strtolower(trim($prodi->durasi));
            preg_match('/(\d+)\s*(bulan|tahun|minggu|hari)/i', $durasiStr, $matches);
            
            $date = clone $registeredAt;
            if (count($matches) === 3) {
                $amount = (int) $matches[1];
                $unit = strtolower($matches[2]);
                if ($unit === 'bulan') $date->addMonths($amount);
                elseif ($unit === 'tahun') $date->addYears($amount);
                elseif ($unit === 'minggu') $date->addWeeks($amount);
                elseif ($unit === 'hari') $date->addDays($amount);
            }
            
            if ($maxDate === null || $date > $maxDate) {
                $maxDate = $date;
            }
        }
        return $maxDate;
    }

    public function checkProdiCompletion($prodi_id)
    {
        // Get all Makul for this prodi
        $makulIds = \App\Models\Makul::where('prodi_id', $prodi_id)->pluck('id');
        if ($makulIds->isEmpty()) return false;

        // Get all Tugas for these Makul
        $allTugasCount = \App\Models\Tugas::whereIn('makul_id', $makulIds)->count();
        if ($allTugasCount === 0) return false;

        // Get count of submitted and graded Tugas for this user
        $gradedTugasCount = $this->submissions()
            ->whereHas('tugas', function ($query) use ($makulIds) {
                $query->whereIn('makul_id', $makulIds);
            })
            ->whereNotNull('nilai')
            ->count();

        return $gradedTugasCount >= $allTugasCount;
    }

    // ---- SCOPES ----
    public function scopeMahasiswa($query) { return $query->where('role', 'mahasiswa'); }
    public function scopeDosen($query) { return $query->where('role', 'dosen'); }
}
