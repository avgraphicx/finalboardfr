<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Driver;

class DriverPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $broker = $user->broker;

        if (!$broker || !$broker->subscriptionType) {
            return false;
        }

        $limit = $broker->subscriptionType->max_drivers;
        $currentCount = Driver::where('broker_id', $broker->id)->count();

        return $currentCount < $limit;
    }
}
