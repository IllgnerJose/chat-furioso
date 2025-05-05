<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;

Broadcast::channel('App.Models.User.{id}', function (User $user, int $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('messages.game.{id}', function (User $user) {
    return true;
});

Broadcast::channel('comments.game.{id}', function (User $user) {
    return true;
});

Broadcast::channel('game.start.{id}', function (User $user) {
    return true;
});

Broadcast::channel('game.win.{id}', function (User $user) {
    return true;
});

