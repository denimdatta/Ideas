<?php

namespace App\Enums;

enum IdeaStatus: string
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case CANCELED = 'canceled';
    case COMPLETED = 'completed';
}
