<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Collaboration extends Model
{
    use HasFactory;

    protected $fillable = [
        'formation_id', 'owner_id', 'collaborator_id', 'status'
    ];

    public function formation(): BelongsTo { return $this->belongsTo(Formation::class); }
    public function owner(): BelongsTo { return $this->belongsTo(User::class, 'owner_id'); }
    public function collaborator(): BelongsTo { return $this->belongsTo(User::class, 'collaborator_id'); }
}


