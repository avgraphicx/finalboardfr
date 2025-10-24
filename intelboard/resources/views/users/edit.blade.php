@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5>{{ __('messages.edit_user') ?? 'Edit User' }}</h5>
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.name') ?? 'Name' }}</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('messages.save') ?? 'Save' }}</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">{{ __('messages.cancel') ?? 'Cancel' }}</a>
            </form>
        </div>
    </div>
@endsection
