<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Message extends Model
{
    protected $fillable = [
        'user_id',
        'game_id',
        'message'
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function game(): HasOne
    {
        return $this->hasOne(Game::class);
    }
}
