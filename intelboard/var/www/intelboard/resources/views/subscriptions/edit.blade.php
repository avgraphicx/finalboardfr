@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5>{{ __('messages.edit_subscription') ?? 'Edit Subscription' }}</h5>
            <form action="{{ route('subscriptions.update', $subscription) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.broker') ?? 'Broker' }}</label>
                    <select name="broker_id" class="form-select" required>
                        @foreach ($brokers as $broker)
                            <option value="{{ $broker->id }}"
                                {{ $subscription->broker_id == $broker->id ? 'selected' : '' }}>{{ $broker->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.type') ?? 'Type' }}</label>
                    <select name="subscription_type_id" class="form-select" required>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}"
                                {{ $subscription->subscription_type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('messages.save') ?? 'Save' }}</button>
                <a href="{{ route('subscriptions.index') }}"
                    class="btn btn-secondary">{{ __('messages.cancel') ?? 'Cancel' }}</a>
            </form>
        </div>
    </div>
@endsection
