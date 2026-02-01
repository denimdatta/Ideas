<?php

namespace App\Enums;

enum IdeaStatus: string
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case CANCELED = 'canceled';
    case COMPLETED = 'completed';

    public function getDisplayName(): string
    {
        return match ($this) {
            self::OPEN => 'Open',
            self::IN_PROGRESS => 'In Progress',
            self::CANCELED => 'Canceled',
            self::COMPLETED => 'Completed',
            default => 'Unknown',
        };
    }
}
