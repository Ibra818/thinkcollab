<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeedVideoComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'feed_video_id',
        'user_id',
        'parent_id',
        'content',
        'likes_count',
    ];

    public function feedVideo(): BelongsTo
    {
        return $this->belongsTo(FeedVideo::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(CommentLike::class, 'feed_video_comment_id');
    }
}
