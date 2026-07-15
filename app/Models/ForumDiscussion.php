<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumDiscussion extends Model
{
    protected $fillable = ['makul_id', 'user_id', 'title', 'body', 'is_pinned'];

    protected $casts = ['is_pinned' => 'boolean'];

    public function makul(): BelongsTo
    {
        return $this->belongsTo(Makul::class, 'makul_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ForumReply::class, 'discussion_id');
    }

    public function topLevelReplies(): HasMany
    {
        return $this->hasMany(ForumReply::class, 'discussion_id')->whereNull('parent_id');
    }
}
