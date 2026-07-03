<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materi extends Model
{
    protected $table = 'materi';

    protected $fillable = [
        'kode_materi', 'nama_materi', 'deskripsi_materi', 'file_materi', 'youtube_link', 'makul_id',
    ];

    public function makul(): BelongsTo
    {
        return $this->belongsTo(Makul::class, 'makul_id');
    }

    public function tugas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Tugas::class, 'materi_id');
    }

    public function getYoutubeEmbedUrl(): ?string
    {
        if (!$this->youtube_link) {
            return null;
        }
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i';
        if (preg_match($pattern, $this->youtube_link, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
        return null;
    }
}
