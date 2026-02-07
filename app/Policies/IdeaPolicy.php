<?php

namespace App\Policies;

use App\Models\Idea;
use App\Models\User;

class IdeaPolicy
{
    /**
     * Determine whether the user have full access the model element.
     */
    public function access(User $user, Idea $idea): bool
    {
        return $user->is($idea->user);
    }

    /**
     * Determine whether the user can view the model element.
     */
    public function view(User $user, Idea $idea): bool
    {
        return true;
    }
}
