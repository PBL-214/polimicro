<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    protected $fillable = ['makul_id', 'user_id', 'title', 'body', 'is_global', 'published_at'];

    protected $casts = [
        'is_global' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function makul(): BelongsTo
    {
        return $this->belongsTo(Makul::class, 'makul_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}
