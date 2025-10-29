<?php

namespace App\Policies;

use App\Models\Broker;
use App\Models\User;
use App\Services\SubscriptionService;

class BrokerPolicy
{
    protected SubscriptionService $subscriptionService;

    public function __construct()
    {
        $this->subscriptionService = app(SubscriptionService::class);
    }

    /**
     * Determine whether the user can add a supervisor under the given broker.
     */
    public function addSupervisor(User $user, Broker $broker): bool
    {
        return $this->subscriptionService->canAddSupervisor($broker->user);
    }

    /**
     * Determine whether the user can generate custom invoices.
     */
    public function useCustomInvoice(User $user, Broker $broker): bool
    {
        return $this->subscriptionService->canCreateCustomInvoice($broker->user);
    }

    /**
     * Determine whether the user can upload multiple files.
     */
    public function uploadMultipleFiles(User $user, Broker $broker): bool
    {
        $plan = $this->subscriptionService->getPlan($broker->user);

        if (!$plan) {
            return false;
        }

        return ($plan->max_files ?? 0) > 1;
    }
}
