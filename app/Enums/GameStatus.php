<?php

namespace App\Enums;

enum GameStatus: string
{
    case Scheduled = 'scheduled';
    case InProgress = 'in_progress';
    case Finished = 'finished';
    case Canceled = 'canceled';
}
