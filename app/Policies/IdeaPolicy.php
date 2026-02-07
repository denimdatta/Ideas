<?php

namespace App\Policies;

use App\Models\Idea;
use App\Models\User;

class IdeaPolicy
{
    /**
     * Determine whether the user can access the model element.
     */
    public function access(User $user, Idea $idea): bool
    {
        return $user->is($idea->user);
    }
}
