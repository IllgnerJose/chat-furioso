<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Round extends Model
{
    protected $fillable = [
        'game_id',
        'round_start',
        'round_end',
        'team_1_score',
        'team_2_score',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function comments(): HasMany
    {
        return $this->HasMany(Comment::class);
    }
}
