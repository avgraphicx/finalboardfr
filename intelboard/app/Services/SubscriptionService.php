<?php

namespace App\Services;

use App\Models\User;
use App\Models\Subscription;

class SubscriptionService
{
    /**
     * Get the active subscription for a user.
     */
    public function getActiveSubscription(?User $user = null): ?Subscription
    {
        $user = $user ?? auth()->user();

        if (!$user) {
            return null;
        }

        // Load subscription with subscriptionType if not already loaded
        if (!$user->relationLoaded('legacySubscription')) {
            $user->load('legacySubscription.subscriptionType');
        }

        $subscription = $user->legacySubscription;

        if (!$subscription || !$subscription->isActive()) {
            return null;
        }

        return $subscription;
    }

    /**
     * Check if user can add more drivers.
     */
    public function canAddDriver(?User $user = null): bool
    {
        $subscription = $this->getActiveSubscription($user);

        if (!$subscription || !$subscription->subscriptionType) {
            return false;
        }

        $maxDrivers = $subscription->subscriptionType->max_drivers;

        // If max_drivers is 0, unlimited drivers allowed
        if ($maxDrivers === 0) {
            return true;
        }

        $user = $user ?? auth()->user();
        $currentDriverCount = $user->drivers()->count();

        return $currentDriverCount < $maxDrivers;
    }

    /**
     * Get the current and maximum driver count for a user.
     */
    public function getDriverLimitInfo(?User $user = null): array
    {
        $user = $user ?? auth()->user();
        $subscription = $this->getActiveSubscription($user);

        if (!$subscription || !$subscription->subscriptionType) {
            return [
                'current' => 0,
                'max' => 0,
                'can_add' => false,
            ];
        }

        $maxDrivers = $subscription->subscriptionType->max_drivers;
        $currentDriverCount = $user->drivers()->count();

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
        $subscription = $this->getActiveSubscription($user);

        if (!$subscription || !$subscription->subscriptionType) {
            return false;
        }

        return (bool) $subscription->subscriptionType->add_supervisor;
    }

    /**
     * Check if user can create custom invoices.
     */
    public function canCreateCustomInvoice(?User $user = null): bool
    {
        $subscription = $this->getActiveSubscription($user);

        if (!$subscription || !$subscription->subscriptionType) {
            return false;
        }

        return (bool) $subscription->subscriptionType->custom_invoice;
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
        $subscription = $this->getActiveSubscription($user);

        if (!$subscription || !$subscription->subscriptionType) {
            return false;
        }

        $maxFiles = $subscription->subscriptionType->max_files;

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
        $subscription = $this->getActiveSubscription($user);

        if (!$subscription || !$subscription->subscriptionType) {
            return 'basic'; // Default to basic if no subscription
        }

        return $subscription->subscriptionType->stats_type ?? 'basic';
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
        $subscription = $this->getActiveSubscription($user);

        if (!$subscription || !$subscription->subscriptionType) {
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
            'max_drivers' => $subscription->subscriptionType->max_drivers,
            'max_files' => $subscription->subscriptionType->max_files,
            'can_add_supervisor' => (bool) $subscription->subscriptionType->add_supervisor,
            'can_create_custom_invoice' => (bool) $subscription->subscriptionType->custom_invoice,
            'stats_type' => $subscription->subscriptionType->stats_type ?? 'basic',
        ];
    }
}
