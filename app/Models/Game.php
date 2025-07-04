<?php

namespace App\Models;
use App\Enums\GameStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    protected $fillable = [
        'team_1_id',
        'team_2_id',
        'game_date',
        'game_start',
        'game_end',
        'status',
    ];

    protected $casts = [
        'status' => GameStatus::class,
    ];

    public function team1(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_1_id');
    }

    public function team2(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_2_id');
    }

    public function messages(): HasMany
    {
        return $this->HasMany(Message::class);
    }

    public function rounds(): HasMany
    {
        return $this->HasMany(Round::class);
    }
}
