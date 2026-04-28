<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materi extends Model
{
    protected $table = 'materi';

    protected $fillable = [
        'kode_materi', 'nama_materi', 'deskripsi_materi', 'file_materi', 'makul_id',
    ];

    public function makul(): BelongsTo
    {
        return $this->belongsTo(Makul::class, 'makul_id');
    }
}
