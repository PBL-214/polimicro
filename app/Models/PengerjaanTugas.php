<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengerjaanTugas extends Model
{
    protected $table = 'pengerjaan_tugas';

    protected $fillable = [
        'mahasiswa_id', 'tugas_id', 'file_dikumpul', 'waktu_kumpul', 'nilai', 'feedback',
    ];

    protected function casts(): array
    {
        return [
            'waktu_kumpul' => 'datetime',
            'nilai' => 'decimal:2',
        ];
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function tugas(): BelongsTo
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }
}
