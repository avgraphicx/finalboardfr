<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Broker;

class BrokerPolicy
{
    /**
     * Determine whether the user can add a supervisor.
     */
    public function addSupervisor(User $user, Broker $broker): bool
    {
        return $broker->subscriptionType && $broker->subscriptionType->add_supervisor;
    }

    /**
     * Determine whether the user can use a custom invoice.
     */
    public function useCustomInvoice(User $user, Broker $broker): bool
    {
        return $broker->subscriptionType && $broker->subscriptionType->custom_invoice;
    }

    /**
     * Determine whether the user can upload multiple files.
     */
    public function uploadMultipleFiles(User $user, Broker $broker): bool
    {
        return $broker->subscriptionType && $broker->subscriptionType->max_files > 1;
    }
}
