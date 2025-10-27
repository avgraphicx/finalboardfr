<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionType;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of subscriptions.
     */
    public function index()
    {
        $subscriptions = Subscription::with('broker', 'subscriptionType')->paginate(20);
        return view('subscriptions.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new subscription.
     */
    public function create()
    {
        $brokers = User::brokers()->where('active', true)->get();
        $types = SubscriptionType::all();
        return view('subscriptions.create', compact('brokers', 'types'));
    }

    /**
     * Store a newly created subscription.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'broker_id' => 'required|exists:users,id',
            'subscription_type_id' => 'required|exists:subscription_types,id',
            'stripe_subscription_id' => 'nullable|string',
            'stripe_status' => 'required|in:active,inactive,past_due',
            'started_at' => 'required|date',
            'ends_at' => 'required|date|after:started_at',
            'price_paid' => 'required|numeric|min:0',
            'auto_renew' => 'boolean',
        ]);

        Subscription::create($validated);
        return redirect()->route('subscriptions.index')->with('success', 'Subscription created successfully');
    }

    /**
     * Display the specified subscription.
     */
    public function show(Subscription $subscription)
    {
        return view('subscriptions.show', compact('subscription'));
    }

    /**
     * Show the form for editing.
     */
    public function edit(Subscription $subscription)
    {
        $brokers = User::brokers()->get();
        $types = SubscriptionType::all();
        return view('subscriptions.edit', compact('subscription', 'brokers', 'types'));
    }

    /**
     * Update the specified subscription.
     */
    public function update(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'stripe_status' => 'sometimes|in:active,inactive,past_due',
            'ends_at' => 'sometimes|date',
            'price_paid' => 'sometimes|numeric|min:0',
            'auto_renew' => 'sometimes|boolean',
        ]);

        $subscription->update($validated);
        return redirect()->route('subscriptions.show', $subscription)->with('success', 'Subscription updated successfully');
    }

    /**
     * Remove the specified subscription.
     */
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return redirect()->route('subscriptions.index')->with('success', 'Subscription deleted successfully');
    }
}
