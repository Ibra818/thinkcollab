<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['name','owner_id'];

    public function members(): HasMany { return $this->hasMany(GroupMember::class); }
    public function messages(): HasMany { return $this->hasMany(GroupMessage::class); }
}


