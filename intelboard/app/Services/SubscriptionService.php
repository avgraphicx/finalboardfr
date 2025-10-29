<?php

namespace App\Services;

use App\Models\User;
use App\Models\CashierSubscription;
use App\Models\SubscriptionType;
use App\Models\Driver;

class SubscriptionService
{
    /**
     * Get the active subscription for a user.
     */
    public function getActiveSubscription(?User $user = null): ?CashierSubscription
    {
        $user = $user ?? auth()->user();

        if (!$user) {
            return null;
        }

        if (!$user->relationLoaded('subscriptions')) {
            $user->load('subscriptions.plan');
        }

        $subscription = $user->currentCashierSubscription();

        if (!$subscription) {
            return null;
        }

        $subscription->loadMissing('plan');

        return $subscription->isActive() ? $subscription : null;
    }

    /**
     * Resolve the subscription plan meta information.
     */
    protected function getSubscriptionPlan(?User $user = null): ?SubscriptionType
    {
        return $this->getActiveSubscription($user)?->plan;
    }

    /**
     * Public accessor to retrieve the resolved plan metadata.
     */
    public function getPlan(?User $user = null): ?SubscriptionType
    {
        return $this->getSubscriptionPlan($user);
    }

    /**
     * Check if user can add more drivers.
     */
    public function canAddDriver(?User $user = null): bool
    {
        $plan = $this->getSubscriptionPlan($user);

        if (!$plan) {
            return false;
        }

        $maxDrivers = $plan->max_drivers;

        // If max_drivers is 0, unlimited drivers allowed
        if ($maxDrivers === 0) {
            return true;
        }

        $user = $user ?? auth()->user();
        $currentDriverCount = $this->countDriversFor($user);

        return $currentDriverCount < $maxDrivers;
    }

    /**
     * Get the current and maximum driver count for a user.
     */
    public function getDriverLimitInfo(?User $user = null): array
    {
        $user = $user ?? auth()->user();
        $plan = $this->getSubscriptionPlan($user);

        if (!$plan) {
            return [
                'current' => 0,
                'max' => 0,
                'can_add' => false,
            ];
        }

        $maxDrivers = $plan->max_drivers;
        $currentDriverCount = $this->countDriversFor($user);

        return [
            'current' => $currentDriverCount,
            'max' => $maxDrivers,
            'can_add' => $maxDrivers === 0 || $currentDriverCount < $maxDrivers,
        ];
    }

    /**
     * Check if user can add supervisors.
     */
    public function canAddSupervisor(?User $user = null): bool
    {
        $plan = $this->getSubscriptionPlan($user);

        if (!$plan) {
            return false;
        }

        return (bool) $plan->add_supervisor;
    }

    /**
     * Check if user can create custom invoices.
     */
    public function canCreateCustomInvoice(?User $user = null): bool
    {
        $plan = $this->getSubscriptionPlan($user);

        if (!$plan) {
            return false;
        }

        return (bool) $plan->custom_invoice;
    }

    /**
     * Check if user has an active subscription.
     */
    public function hasActiveSubscription(?User $user = null): bool
    {
        return $this->getActiveSubscription($user) !== null;
    }

    /**
     * Check if user can upload more files.
     */
    public function canUploadFile(?User $user = null): bool
    {
        $plan = $this->getSubscriptionPlan($user);

        if (!$plan) {
            return false;
        }

        $maxFiles = $plan->max_files;

        // If max_files is 0, unlimited files allowed
        if ($maxFiles === 0) {
            return true;
        }

        // TODO: Implement file counting when file uploads are implemented
        // $user = $user ?? auth()->user();
        // $currentFileCount = $user->files()->count();
        // return $currentFileCount < $maxFiles;

        return true; // For now, always allow until file system is implemented
    }

    /**
     * Get the stats type access level for a user.
     * Returns: 'basic', 'advanced', 'premium', or null
     */
    public function getStatsType(?User $user = null): ?string
    {
        $plan = $this->getSubscriptionPlan($user);

        if (!$plan) {
            return 'basic'; // Default to basic if no subscription
        }

        return $plan->stats_type ?? 'basic';
    }

    /**
     * Check if user has access to a specific stats type.
     */
    public function hasStatsAccess(string $requiredType, ?User $user = null): bool
    {
        $userStatsType = $this->getStatsType($user);

        // Stats hierarchy: basic < advanced < premium
        $hierarchy = ['basic' => 1, 'advanced' => 2, 'premium' => 3];

        $userLevel = $hierarchy[$userStatsType] ?? 1;
        $requiredLevel = $hierarchy[$requiredType] ?? 1;

        return $userLevel >= $requiredLevel;
    }

    /**
     * Get all subscription features for a user.
     */
    public function getSubscriptionFeatures(?User $user = null): array
    {
        $plan = $this->getSubscriptionPlan($user);

        if (!$plan) {
            return [
                'has_active_subscription' => false,
                'max_drivers' => 0,
                'max_files' => 0,
                'can_add_supervisor' => false,
                'can_create_custom_invoice' => false,
                'stats_type' => 'basic',
            ];
        }

        return [
            'has_active_subscription' => true,
            'max_drivers' => $plan->max_drivers,
            'max_files' => $plan->max_files,
            'can_add_supervisor' => (bool) $plan->add_supervisor,
            'can_create_custom_invoice' => (bool) $plan->custom_invoice,
            'stats_type' => $plan->stats_type ?? 'basic',
        ];
    }

    /**
     * Count drivers for a broker, aggregating supervisors they manage.
     */
    protected function countDriversFor(User $user): int
    {
        $userIds = $this->resolveTeamUserIds($user);

        return Driver::whereIn('created_by', $userIds)->count();
    }

    /**
     * Resolve the full set of user IDs that contribute to resource limits.
     *
     * Brokers count themselves plus their created users (e.g., supervisors).
     * Supervisors defer to their broker owner.
     *
     * @return array<int, int>
     */
    protected function resolveTeamUserIds(User $user): array
    {
        $brokerUser = $user->isBroker() ? $user : $user->createdBy;

        if (!$brokerUser) {
            return [$user->id];
        }

        $ids = $brokerUser->createdUsers()->pluck('id')->push($brokerUser->id);

        return $ids->unique()->all();
    }
}
