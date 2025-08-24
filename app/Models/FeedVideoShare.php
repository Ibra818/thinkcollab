<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedVideoShare extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'feed_video_id',
        'platform',
        'ip_address',
        'shared_at',
    ];

    public $timestamps = false;
    protected $dates = ['shared_at'];

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
