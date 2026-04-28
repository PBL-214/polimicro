<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sertifikat extends Model
{
    protected $table = 'sertifikat';

    protected $fillable = [
        'mahasiswa_id', 'prodi_id', 'nomor_sertifikat', 'tanggal_terbit', 'status', 'file_sertifikat'
    ];

    protected function casts(): array
    {
        return [
            'tanggal_terbit' => 'date',
        ];
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(ProdiMikro::class, 'prodi_id');
    }
}
