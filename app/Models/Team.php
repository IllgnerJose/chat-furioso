<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    protected $fillable = [
        'team',
        'logo_path',
    ];

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }
}
