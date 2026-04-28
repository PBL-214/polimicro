<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProdiMikro extends Model
{
    protected $table = 'prodi_mikro';

    protected $fillable = [
        'kode_prodi', 'nama_prodi', 'deskripsi', 'durasi', 'icon', 'status', 'nid',
    ];

    public function makul(): HasMany
    {
        return $this->hasMany(Makul::class, 'prodi_id');
    }

    public function pendaftaran(): HasMany
    {
        return $this->hasMany(Pendaftaran::class, 'prodi_id');
    }

    public function sertifikat(): HasMany
    {
        return $this->hasMany(Sertifikat::class, 'prodi_id');
    }

    public function pendaftaranDiterima()
    {
        return $this->pendaftaran()->where('status', 'diterima');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
