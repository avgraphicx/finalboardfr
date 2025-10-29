@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5>{{ __('messages.create_subscription') ?? 'Create Subscription' }}</h5>
            <form action="{{ route('subscriptions.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('messages.broker') ?? 'Broker' }}</label>
                        <select name="user_id" class="form-select" required>
                            <option value="">{{ __('messages.select_broker') ?? 'Select Broker' }}</option>
                            @foreach ($brokers as $broker)
                                <option value="{{ $broker->id }}" @selected(old('user_id') == $broker->id)>
                                    {{ $broker->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('messages.type') ?? 'Plan' }}</label>
                        <select name="subscription_type_id" class="form-select">
                            <option value="">{{ __('messages.select_type') ?? 'Select Plan (optional)' }}</option>
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}" @selected(old('subscription_type_id') == $plan->id)>
                                    {{ $plan->name }} @if ($plan->price)
                                        ({{ number_format($plan->price, 2) }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted d-block mt-1">
                            Selecting a plan will pre-fill the Stripe price.
                        </small>
                    </div>
                </div>
                <div class="row g-3 mt-1">
                    <div class="col-md-4">
                        <label class="form-label">Stripe Subscription ID</label>
                        <input type="text" name="stripe_id" class="form-control" value="{{ old('stripe_id') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Stripe Status</label>
                        <select name="stripe_status" class="form-select" required>
                            @foreach (['active', 'trialing', 'incomplete', 'canceled', 'past_due', 'unpaid'] as $status)
                                <option value="{{ $status }}" @selected(old('stripe_status', 'active') == $status)>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Type (nickname)</label>
                        <input type="text" name="type" class="form-control" value="{{ old('type', 'default') }}">
                    </div>
                </div>
                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label class="form-label">Stripe Price</label>
                        <input type="text" name="stripe_price" class="form-control"
                            value="{{ old('stripe_price') }}">
                        <small class="text-muted d-block mt-1">
                            Override the price retrieved from the plan selection if needed.
                        </small>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" min="1" class="form-control"
                            value="{{ old('quantity', 1) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Trial Ends At</label>
                        <input type="date" name="trial_ends_at" class="form-control"
                            value="{{ old('trial_ends_at') }}">
                    </div>
                </div>
                <div class="row g-3 mt-1">
                    <div class="col-md-3">
                        <label class="form-label">Ends At</label>
                        <input type="date" name="ends_at" class="form-control" value="{{ old('ends_at') }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('messages.create') ?? 'Create' }}</button>
                <a href="{{ route('subscriptions.index') }}"
                    class="btn btn-secondary">{{ __('messages.cancel') ?? 'Cancel' }}</a>
            </form>
        </div>
    </div>
@endsection
