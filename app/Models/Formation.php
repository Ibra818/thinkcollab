<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\FeedVideo;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'prix',
        'statut',
        'categorie_id',
        'formateur_id',
        'image_couverture',
    ];

    protected $casts = [
        'prix' => 'integer',
    ];

    // Relations
    public function formateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'formateur_id');
    }

    public function feedvideos(): HasMany
    {
        return $this->hasMany(FeedVideo::class);
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }

    public function lessonVideos(): HasMany
    {
        return $this->hasMany(LessonVideo::class);
    }

    public function videoPresentation(): HasOne
    {
        return $this->hasOne(VideoPresentation::class);
    }

    public function objectives(): HasMany
    {
        return $this->hasMany(FormationObjective::class)->orderBy('ordre');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(FormationSection::class)->orderBy('ordre');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('statut', 'publie');
    }

    public function scopeDraft($query)
    {
        return $query->where('statut', 'brouillon');
    }

    // Helper methods
    public function hasFeedVideos(): bool
    {
        return $this->feedvideos()->exists();
    }

    public function getTotalFeedVideosCount(): int
    {
        return $this->feedvideos()->count();
    }

    public function getTotalFeedVideosDuration(): int
    {
        return $this->feedvideos()->sum('duree');
    }
}
