<?php

namespace App\Models;

use Laravel\Cashier\Subscription as CashierSubscriptionModel;

class CashierSubscription extends CashierSubscriptionModel
{
    /**
     * Use a dedicated table to avoid clashing with the legacy subscriptions schema.
     */
    protected $table = 'cashier_subscriptions';
}

