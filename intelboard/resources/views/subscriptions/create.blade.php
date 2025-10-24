@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5>{{ __('messages.create_subscription') ?? 'Create Subscription' }}</h5>
            <form action="{{ route('subscriptions.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.broker') ?? 'Broker' }}</label>
                    <select name="broker_id" class="form-select" required>
                        <option value="">{{ __('messages.select_broker') ?? 'Select Broker' }}</option>
                        @foreach ($brokers as $broker)
                            <option value="{{ $broker->id }}">{{ $broker->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.type') ?? 'Type' }}</label>
                    <select name="subscription_type_id" class="form-select" required>
                        <option value="">{{ __('messages.select_type') ?? 'Select Type' }}</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('messages.create') ?? 'Create' }}</button>
                <a href="{{ route('subscriptions.index') }}"
                    class="btn btn-secondary">{{ __('messages.cancel') ?? 'Cancel' }}</a>
            </form>
        </div>
    </div>
@endsection
