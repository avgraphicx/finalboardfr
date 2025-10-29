@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5>{{ __('messages.edit_subscription') ?? 'Edit Subscription' }}</h5>
            <form action="{{ route('subscriptions.update', $subscription) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('messages.broker') ?? 'Broker' }}</label>
                        <input type="text" class="form-control" value="{{ $subscription->user?->full_name ?? 'Unknown' }}"
                            disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Stripe Subscription ID</label>
                        <input type="text" class="form-control" value="{{ $subscription->stripe_id }}" disabled>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-4">
                        <label class="form-label">Stripe Status</label>
                        <select name="stripe_status" class="form-select">
                            @foreach (['active', 'trialing', 'incomplete', 'canceled', 'past_due', 'unpaid'] as $status)
                                <option value="{{ $status }}" @selected($subscription->stripe_status === $status)>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('messages.type') ?? 'Plan' }}</label>
                        <select name="subscription_type_id" class="form-select">
                            <option value="">{{ __('messages.select_type') ?? 'Select Plan (optional)' }}</option>
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}" @selected($subscription->plan?->id === $plan->id)>
                                    {{ $plan->name }}
                                    @if ($plan->price)
                                        ({{ number_format($plan->price, 2) }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Stripe Price</label>
                        <input type="text" name="stripe_price" class="form-control"
                            value="{{ old('stripe_price', $subscription->stripe_price) }}">
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" min="1" class="form-control"
                            value="{{ old('quantity', $subscription->quantity ?? 1) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Trial Ends At</label>
                        <input type="date" name="trial_ends_at" class="form-control"
                            value="{{ old('trial_ends_at', optional($subscription->trial_ends_at)->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Ends At</label>
                        <input type="date" name="ends_at" class="form-control"
                            value="{{ old('ends_at', optional($subscription->ends_at)->format('Y-m-d')) }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('messages.save') ?? 'Save' }}</button>
                <a href="{{ route('subscriptions.index') }}"
                    class="btn btn-secondary">{{ __('messages.cancel') ?? 'Cancel' }}</a>
            </form>
        </div>
    </div>
@endsection
