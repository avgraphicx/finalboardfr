@extends('layouts.master')

@section('content')
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.create_user') ?? 'Create User' }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('messages.users') ?? 'Users' }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.create') ?? 'Create' }}</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">{{ __('messages.user_information') ?? 'User Information' }}</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.name') ?? 'Name' }}</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.email') ?? 'Email' }}</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.role') ?? 'Role' }}</label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="">{{ __('messages.select_role') ?? 'Select Role' }}</option>
                                <option value="1">{{ __('messages.admin') ?? 'Admin' }}</option>
                                <option value="2">{{ __('messages.broker') ?? 'Broker' }}</option>
                                <option value="3">{{ __('messages.supervisor') ?? 'Supervisor' }}</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">{{ __('messages.create') ?? 'Create' }}</button>
                            <a href="{{ route('users.index') }}"
                                class="btn btn-secondary">{{ __('messages.cancel') ?? 'Cancel' }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
