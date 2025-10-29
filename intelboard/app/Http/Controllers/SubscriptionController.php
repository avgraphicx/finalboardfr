<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionType;
use App\Models\CashierSubscription;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of subscriptions.
     */
    public function index()
    {
        $subscriptions = CashierSubscription::with(['user', 'plan'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('subscriptions.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new subscription.
     */
    public function create()
    {
        $brokers = User::brokers()->where('active', true)->get();
        $plans = SubscriptionType::orderBy('price')->get();

        return view('subscriptions.create', compact('brokers', 'plans'));
    }

    /**
     * Store a newly created subscription.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'nullable|string|max:120',
            'stripe_id' => 'required|string|max:190|unique:cashier_subscriptions,stripe_id',
            'stripe_status' => 'required|string|in:active,trialing,incomplete,canceled,past_due,unpaid',
            'subscription_type_id' => 'nullable|exists:subscription_types,id',
            'stripe_price' => 'nullable|string|max:190',
            'quantity' => 'nullable|integer|min:1',
            'trial_ends_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:trial_ends_at',
        ]);

        $plan = null;

        if (!empty($validated['subscription_type_id'])) {
            $plan = SubscriptionType::find($validated['subscription_type_id']);
        }

        $stripePrice = $validated['stripe_price'] ?? $plan?->stripe_plan_id;

        CashierSubscription::create([
            'user_id' => $validated['user_id'],
            'type' => $validated['type'] ?? 'default',
            'stripe_id' => $validated['stripe_id'],
            'stripe_status' => $validated['stripe_status'],
            'stripe_price' => $stripePrice,
            'quantity' => $validated['quantity'] ?? 1,
            'trial_ends_at' => $validated['trial_ends_at'] ?? null,
            'ends_at' => $validated['ends_at'] ?? null,
        ]);

        return redirect()->route('subscriptions.index')
            ->with('success', 'Subscription created successfully');
    }

    /**
     * Display the specified subscription.
     */
    public function show(CashierSubscription $subscription)
    {
        $subscription->loadMissing('user', 'plan');

        return view('subscriptions.show', compact('subscription'));
    }

    /**
     * Show the form for editing.
     */
    public function edit(CashierSubscription $subscription)
    {
        $subscription->loadMissing('plan', 'user');
        $plans = SubscriptionType::orderBy('price')->get();

        return view('subscriptions.edit', compact('subscription', 'plans'));
    }

    /**
     * Update the specified subscription.
     */
    public function update(Request $request, CashierSubscription $subscription)
    {
        $validated = $request->validate([
            'stripe_status' => 'sometimes|string|in:active,trialing,incomplete,canceled,past_due,unpaid',
            'subscription_type_id' => 'nullable|exists:subscription_types,id',
            'stripe_price' => 'nullable|string|max:190',
            'quantity' => 'nullable|integer|min:1',
            'trial_ends_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:trial_ends_at',
        ]);

        $plan = null;

        if (!empty($validated['subscription_type_id'])) {
            $plan = SubscriptionType::find($validated['subscription_type_id']);
        }

        $stripePrice = $validated['stripe_price'] ?? $plan?->stripe_plan_id ?? $subscription->stripe_price;

        $subscription->update([
            'stripe_status' => $validated['stripe_status'] ?? $subscription->stripe_status,
            'stripe_price' => $stripePrice,
            'quantity' => $validated['quantity'] ?? $subscription->quantity,
            'trial_ends_at' => $validated['trial_ends_at'] ?? $subscription->trial_ends_at,
            'ends_at' => $validated['ends_at'] ?? $subscription->ends_at,
        ]);

        return redirect()->route('subscriptions.show', $subscription)
            ->with('success', 'Subscription updated successfully');
    }

    /**
     * Remove the specified subscription.
     */
    public function destroy(CashierSubscription $subscription)
    {
        $subscription->delete();

        return redirect()->route('subscriptions.index')
            ->with('success', 'Subscription deleted successfully');
    }
}
