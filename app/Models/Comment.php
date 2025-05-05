<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        "comment",
        "round_id",
    ];

    public function round(): BelongsTo
    {
        return $this->belongsTo(Round::class);
    }
    
}
