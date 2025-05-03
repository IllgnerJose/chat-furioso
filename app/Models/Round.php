<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
