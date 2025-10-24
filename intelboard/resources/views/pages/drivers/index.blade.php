@extends('layouts.master')

@section('content')
    <!-- Start::page-header -->
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.drivers') ?? 'Drivers' }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.drivers') ?? 'Drivers' }}</li>
            </ol>
        </div>
    </div>
    <!-- End::page-header -->

    <div class="row">
        <div class="col-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">{{ __('messages.drivers_list') ?? 'Drivers List' }}</div>
                    <a href="{{ route('drivers.create') }}" class="btn btn-sm btn-primary">
                        <i class="ri-add-line me-2"></i>{{ __('messages.add_driver') ?? 'Add Driver' }}
                    </a>
                </div>
                <div class="card-body">
                    @if ($drivers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.driver_id') ?? 'Driver ID' }}</th>
                                        <th>{{ __('messages.full_name') ?? 'Full Name' }}</th>
                                        <th>{{ __('messages.license_number') ?? 'License #' }}</th>
                                        <th>{{ __('messages.ssn') ?? 'SSN' }}</th>
                                        <th>{{ __('messages.status') ?? 'Status' }}</th>
                                        <th>{{ __('messages.actions') ?? 'Actions' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($drivers as $driver)
                                        <tr>
                                            <td><strong>{{ $driver->driver_id }}</strong></td>
                                            <td>{{ $driver->full_name }}</td>
                                            <td>{{ $driver->license_number ?? 'N/A' }}</td>
                                            <td>{{ $driver->ssn ?? 'N/A' }}</td>
                                            <td>
                                                @if ($driver->active)
                                                    <span
                                                        class="badge bg-success-transparent">{{ __('messages.active') ?? 'Active' }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-danger-transparent">{{ __('messages.inactive') ?? 'Inactive' }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('drivers.show', $driver) }}" class="btn btn-sm btn-info">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('drivers.edit', $driver) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <form action="{{ route('drivers.destroy', $driver) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('{{ __('messages.confirm_delete') ?? 'Are you sure?' }}')">
                                                        <i class="ri-delete-line"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $drivers->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            {{ __('messages.no_drivers') ?? 'No drivers found. Click above to add your first driver.' }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
