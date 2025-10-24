@extends('layouts.master')

@section('content')
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.users') ?? 'Users' }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.users') ?? 'Users' }}</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="card-title">{{ __('messages.users') ?? 'Users' }}</div>
                    <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
                        <i class="ri-add-line me-2"></i>{{ __('messages.add_user') ?? 'Add User' }}
                    </a>
                </div>
                <div class="card-body">
                    @if ($users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.name') ?? 'Name' }}</th>
                                        <th>{{ __('messages.email') ?? 'Email' }}</th>
                                        <th>{{ __('messages.role') ?? 'Role' }}</th>
                                        <th>{{ __('messages.status') ?? 'Status' }}</th>
                                        <th>{{ __('messages.actions') ?? 'Actions' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->full_name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $user->role_name }}</span>
                                            </td>
                                            <td>
                                                @if ($user->active)
                                                    <span
                                                        class="badge bg-success">{{ __('messages.active') ?? 'Active' }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-danger">{{ __('messages.inactive') ?? 'Inactive' }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-info">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('{{ __('messages.confirm_delete') }}')">
                                                        <i class="ri-delete-line"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">{{ __('messages.no_users_found') ?? 'No users found.' }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
