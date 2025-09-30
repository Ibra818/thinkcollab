<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id','sender_id','content','file_path','file_name','file_mime','read_at'
    ];

    public function group(): BelongsTo { return $this->belongsTo(Group::class); }
    public function sender(): BelongsTo { return $this->belongsTo(User::class, 'sender_id'); }
}


