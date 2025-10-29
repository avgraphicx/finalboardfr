<?php

namespace App\Policies;

use App\Models\User;
use App\Services\SubscriptionService;

class DriverPolicy
{
    /**
     * Determine whether the user can create driver records.
     */
    public function create(User $user): bool
    {
        return app(SubscriptionService::class)->canAddDriver($user);
    }
}
