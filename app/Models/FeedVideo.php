<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Formation;

class FeedVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'titre',
        'description',
        'url_video',
        'duree',
        'miniature',
        'formation_id',
        'categorie_id',
        'est_public'
    ];

    protected $casts = [
        'duree' => 'integer',
        'est_public' => 'boolean',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class, 'formation_id');
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(FeedVideoLike::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(FeedVideoView::class);
    }

    public function shares(): HasMany
    {
        return $this->hasMany(FeedVideoShare::class);
    }

    // Helper methods for statistics
    public function getLikesCountAttribute(): int
    {
        return $this->likes()->count();
    }

    public function getViewsCountAttribute(): int
    {
        return $this->views()->count();
    }

    public function getSharesCountAttribute(): int
    {
        return $this->shares()->count();
    }

    public function isLikedByUser($userId): bool
    {
        if (!$userId) return false;
        return $this->likes()->where('user_id', $userId)->exists();
    }
}
