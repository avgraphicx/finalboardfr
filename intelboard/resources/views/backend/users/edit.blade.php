@extends('layouts.master')

@section('title', 'Edit User')

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Edit User: {{ $user->full_name }}</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name"
                                value="{{ old('full_name', $user->full_name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number"
                                value="{{ old('phone_number', $user->phone_number) }}">
                        </div>

                        <div class="mb-3">
                            <label for="active" class="form-label">Status</label>
                            <select class="form-select" id="active" name="active" required>
                                <option value="1" @if (old('active', $user->active) == 1) selected @endif>Active</option>
                                <option value="0" @if (old('active', $user->active) == 0) selected @endif>Inactive</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="subscription_type" class="form-label">Subscription Type</label>
                            <select class="form-select" id="subscription_type" name="subscription_type">
                                <option value="">None</option>
                                @foreach ($subscriptionTypes as $type)
                                    <option value="{{ $type->stripe_plan_id }}"
                                        @if ($user->currentSubscriptionPlan()?->stripe_plan_id == $type->stripe_plan_id) selected @endif>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update User</button>
                        <a href="{{ route('backend.users.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
