<?php

namespace Database\Seeders;

use App\Models\CashierSubscription;
use App\Models\SubscriptionType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class CashierSeeder extends Seeder
{
    public function run(): void
    {
        $plan = SubscriptionType::findOrFail(24); // your chosen plan id

        $userIds = [1, 6, 7, 8, 9, 10];

        foreach ($userIds as $index => $userId) {
            CashierSubscription::updateOrCreate(
                [
                    'user_id'  => $userId,
                    'type'     => 'default',
                ],
                [
                    'stripe_id'     => sprintf('legacy-seed-%d', $userId),
                    'stripe_status' => 'active',
                    'stripe_price'  => $plan->stripe_plan_id,
                    'quantity'      => 1,
                    'trial_ends_at' => null,
                    'ends_at'       => Carbon::now()->addYear(),
                    'created_at'    => now()->subDays($index),
                    'updated_at'    => now()->subDays($index),
                ]
            );
        }
    }
}
