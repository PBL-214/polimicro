<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tugas extends Model
{
    protected $table = 'tugas';

    protected $fillable = [
        'kode_tugas', 'nama_tugas', 'deskripsi_tugas', 'file_tugas', 'format_file',
        'max_nilai', 'tanggal_awal_deadline', 'tanggal_akhir_deadline',
        'materi_id', 'makul_id',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_awal_deadline' => 'date',
            'tanggal_akhir_deadline' => 'date',
        ];
    }

    public function makul(): BelongsTo
    {
        return $this->belongsTo(Makul::class, 'makul_id');
    }

    public function materi(): BelongsTo
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(PengerjaanTugas::class, 'tugas_id');
    }
}
