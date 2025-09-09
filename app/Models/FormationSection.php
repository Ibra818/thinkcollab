<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormationSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'formation_id',
        'titre',
        'description',
        'ordre',
    ];

    protected $casts = [
        'ordre' => 'integer',
    ];

    // Relations
    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }

    public function lessonVideos(): HasMany
    {
        return $this->hasMany(LessonVideo::class, 'formation_section_id')->orderBy('ordre');
    }

    // Helper methods
    public function getTotalDurationAttribute(): int
    {
        return $this->lessonVideos()->sum('duree');
    }

    public function getVideosCountAttribute(): int
    {
        return $this->lessonVideos()->count();
    }
}
