@extends('layouts.master')

@section('content')
    <a href="{{ route('subscriptions.index') }}" class="btn btn-secondary">{{ __('messages.back') }}</a>
    <div class="card mt-3">
        <div class="card-body">
            <h5>{{ __('messages.subscription') ?? 'Subscription' }}</h5>
            <p>{{ __('messages.broker') ?? 'Broker' }}: {{ optional($subscription->user)->full_name ?? 'Unknown' }}</p>
            <p>{{ __('messages.type') ?? 'Plan' }}:
                {{ $subscription->plan?->name ?? 'Unknown' }}</p>
            <p>Stripe Price: {{ $subscription->stripe_price ?? '—' }}</p>
            <p>{{ __('messages.status') ?? 'Status' }}: {{ ucfirst(str_replace('_', ' ', $subscription->stripe_status)) }}</p>
            <p>{{ __('messages.ends_at') ?? 'Ends At' }}: {{ $subscription->ends_at?->format('Y-m-d') ?? '—' }}</p>
        </div>
    </div>
@endsection
