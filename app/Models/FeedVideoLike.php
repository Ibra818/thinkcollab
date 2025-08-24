<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedVideoLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'feed_video_id',
    ];

    public $timestamps = false;
    protected $dates = ['created_at'];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function feedVideo(): BelongsTo
    {
        return $this->belongsTo(FeedVideo::class);
    }
}
