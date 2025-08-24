<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Progression extends Model
{
    use HasFactory;

    protected $fillable = [
        'inscription_id',
        'lesson_video_id',
        'pourcentage',
        'last_seen_at',
    ];

    protected $casts = [
        'pourcentage' => 'integer',
        'last_seen_at' => 'datetime',
    ];

    // Relations
    public function inscription(): BelongsTo
    {
        return $this->belongsTo(Inscription::class);
    }

    public function lessonVideo(): BelongsTo
    {
        return $this->belongsTo(LessonVideo::class);
    }
}
