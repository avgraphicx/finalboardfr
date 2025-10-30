<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionType;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('subscriptions.plan')->latest()->paginate(20);
        return view('backend.users.index', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $subscriptionTypes = SubscriptionType::all();
        return view('backend.users.edit', compact('user', 'subscriptionTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'active' => 'required|boolean',
            'subscription_type' => 'nullable|string|exists:subscription_types,stripe_plan_id',
        ]);

        $user->update($request->only('full_name', 'phone_number', 'active'));

        // Handle subscription change
        $newPlanId = $request->input('subscription_type');
        $currentSubscription = $user->currentCashierSubscription();
        $subscriptionType = $currentSubscription?->type ?? 'default';

        try {
            if ($newPlanId && $currentSubscription?->stripe_price !== $newPlanId) {
                // If user has a subscription that exists on Stripe, swap it
                if ($currentSubscription && $user->subscribed($subscriptionType)) {
                    $user->subscription($subscriptionType)->swap($newPlanId);
                } else {
                    // If user has no real subscription or a legacy one, create a new one
                    $user->newSubscription('default', $newPlanId)->create();
                }
            } elseif (!$newPlanId && $currentSubscription && $user->subscribed($subscriptionType)) {
                // If 'None' is selected and user has a real subscription, cancel it
                $user->subscription($subscriptionType)->cancel();
            }
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // This can happen if the local subscription does not exist on Stripe (e.g. legacy data)
            if ($newPlanId) {
                // The subscription is invalid on Stripe's end, so create a new one.
                $user->newSubscription('default', $newPlanId)->create();
            }
            // If no new plan is selected, we do nothing, as the old one was invalid anyway.
        }


        return redirect()->route('backend.users.index')->with('success', 'User updated successfully.');
    }
}
