@extends('layouts.master')

@section('content')
    <a href="{{ route('users.index') }}" class="btn btn-secondary ms-auto">{{ __('messages.back') }}</a>
    <div class="card mt-3">
        <div class="card-body">
            <h5>{{ $user->full_name }}</h5>
            <p>Email: {{ $user->email }}</p>
            <p>Role: {{ $user->role_name }}</p>
        </div>
    </div>
@endsection
