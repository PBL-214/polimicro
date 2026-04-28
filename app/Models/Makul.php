<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Makul extends Model
{
    protected $table = 'makul';

    protected $fillable = [
        'kode_makul', 'nama_makul', 'deskripsi', 'sks', 'prodi_id', 'dosen_id',
    ];

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(ProdiMikro::class, 'prodi_id');
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function materi(): HasMany
    {
        return $this->hasMany(Materi::class, 'makul_id');
    }

    public function tugas(): HasMany
    {
        return $this->hasMany(Tugas::class, 'makul_id');
    }
}
