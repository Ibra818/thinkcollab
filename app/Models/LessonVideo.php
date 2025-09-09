<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LessonVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'formation_id',
        'titre',
        'url_video',
        'ordre',
        'duree',
        'formation_section_id',
    ];

    protected $casts = [
        'ordre' => 'integer',
        'duree' => 'integer',
    ];

    // Relations
    public function formation(): BelongsTo
    {
        return $this->belongsTo(Formation::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(FormationSection::class, 'formation_section_id');
    }

    public function favoris(): HasMany
    {
        return $this->hasMany(FavoriVideo::class);
    }

    public function progressions(): HasMany
    {
        return $this->hasMany(Progression::class);
    }
}
