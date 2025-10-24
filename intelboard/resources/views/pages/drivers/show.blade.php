@extends('layouts.master')

@section('content')
    <!-- Start::page-header -->
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ $driver->full_name }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('drivers.index') }}">{{ __('messages.drivers') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $driver->driver_id }}</li>
            </ol>
        </div>
    </div>
    <!-- End::page-header -->

    <div class="row">
        <div class="col-lg-4">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">{{ __('messages.driver_information') ?? 'Driver Information' }}</div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">{{ __('messages.driver_id') ?? 'Driver ID' }}</small>
                        <p class="fw-semibold">{{ $driver->driver_id }}</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">{{ __('messages.full_name') ?? 'Full Name' }}</small>
                        <p class="fw-semibold">{{ $driver->full_name }}</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">{{ __('messages.license_number') ?? 'License Number' }}</small>
                        <p class="fw-semibold">{{ $driver->license_number ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">{{ __('messages.ssn') ?? 'SSN' }}</small>
                        <p class="fw-semibold">{{ $driver->ssn ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">{{ __('messages.status') ?? 'Status' }}</small>
                        <p>
                            @if ($driver->active)
                                <span class="badge bg-success">{{ __('messages.active') ?? 'Active' }}</span>
                            @else
                                <span class="badge bg-danger">{{ __('messages.inactive') ?? 'Inactive' }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('drivers.edit', $driver) }}" class="btn btn-warning btn-sm">
                            <i class="ri-edit-line me-2"></i>{{ __('messages.edit') ?? 'Edit' }}
                        </a>
                        <form action="{{ route('drivers.destroy', $driver) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100"
                                onclick="return confirm('{{ __('messages.confirm_delete') }}')">
                                <i class="ri-delete-line me-2"></i>{{ __('messages.delete') ?? 'Delete' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">{{ __('messages.recent_invoices') ?? 'Recent Invoices' }}</div>
                </div>
                <div class="card-body">
                    @if ($invoices->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.week') ?? 'Week' }}</th>
                                        <th>{{ __('messages.warehouse') ?? 'Warehouse' }}</th>
                                        <th>{{ __('messages.parcels') ?? 'Parcels' }}</th>
                                        <th>{{ __('messages.total') ?? 'Total' }}</th>
                                        <th>{{ __('messages.status') ?? 'Status' }}</th>
                                        <th>{{ __('messages.actions') ?? 'Actions' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                        <tr>
                                            <td>{{ $invoice->week_number }}</td>
                                            <td>{{ $invoice->warehouse_name }}</td>
                                            <td>{{ $invoice->total_parcels }}</td>
                                            <td>${{ number_format($invoice->invoice_total, 2) }}</td>
                                            <td>
                                                @if ($invoice->is_paid)
                                                    <span
                                                        class="badge bg-success">{{ __('messages.paid') ?? 'Paid' }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-warning">{{ __('messages.unpaid') ?? 'Unpaid' }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('invoices.show', $invoice) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $invoices->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            {{ __('messages.no_invoices') ?? 'No invoices for this driver.' }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
