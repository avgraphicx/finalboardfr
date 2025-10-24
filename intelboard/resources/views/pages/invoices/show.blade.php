@extends('layouts.master')

@section('content')
    <!-- Start::page-header -->
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.invoice') ?? 'Invoice' }} #{{ $invoice->id }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">{{ __('messages.invoices') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">#{{ $invoice->id }}</li>
            </ol>
        </div>
    </div>
    <!-- End::page-header -->

    <div class="row">
        <div class="col-lg-8">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">{{ __('messages.invoice_details') ?? 'Invoice Details' }}</div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted">{{ __('messages.driver') }}</small>
                            <p class="fw-semibold">
                                <span class="badge bg-primary me-2">{{ $invoice->driver->driver_id ?? 'N/A' }}</span>
                                {{ $invoice->driver->full_name ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">{{ __('messages.week') }}</small>
                            <p class="fw-semibold">{{ $invoice->week_number }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted">{{ __('messages.warehouse') }}</small>
                            <p class="fw-semibold">{{ $invoice->warehouse_name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">{{ __('messages.days_worked') }}</small>
                            <p class="fw-semibold">{{ $invoice->days_worked }}</p>
                        </div>
                    </div>

                    <hr>

                    <h6 class="fw-semibold mb-3">{{ __('messages.financial_summary') ?? 'Financial Summary' }}</h6>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted">{{ __('messages.total_parcels') }}</small>
                            <p class="fw-semibold">{{ $invoice->total_parcels }}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">{{ __('messages.invoice_total') }}</small>
                            <p class="fw-semibold">${{ (int) $invoice->invoice_total }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted">{{ __('messages.vehicle_rental_price') }}</small>
                            <p class="fw-semibold">${{ (int) $invoice->vehicle_rental_price }}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">{{ __('messages.driver_percentage') }}</small>
                            <p class="fw-semibold">{{ (int) $invoice->driver_percentage }}%</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted">{{ __('messages.bonus') }}</small>
                            <p class="fw-semibold">${{ (int) $invoice->bonus }}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">{{ __('messages.cash_advance') }}</small>
                            <p class="fw-semibold">${{ (int) $invoice->cash_advance }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <small class="text-muted">{{ __('messages.penalty') }}</small>
                            <p class="fw-semibold">${{ (int) $invoice->penalty }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <small class="text-muted">{{ __('messages.amount_to_pay_driver') }}</small>
                        <h5 class="text-success fw-semibold">${{ (int) $invoice->amount_to_pay_driver }}</h5>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-warning">
                            <i class="ri-edit-line me-2"></i>{{ __('messages.edit') ?? 'Edit' }}
                        </a>
                        @if (!$invoice->is_paid)
                            <form action="{{ route('invoices.mark-paid', $invoice) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="ri-check-line me-2"></i>{{ __('messages.mark_paid') ?? 'Mark as Paid' }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">{{ __('messages.status') ?? 'Status' }}</div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p class="text-muted">{{ __('messages.payment_status') ?? 'Payment Status' }}</p>
                        @if ($invoice->is_paid)
                            <span class="badge bg-success-transparent fs-6">{{ __('messages.paid') ?? 'Paid' }}</span>
                            @if ($invoice->paid_at)
                                <p class="text-muted small mt-2">{{ __('messages.paid_on') ?? 'Paid on' }}:
                                    {{ $invoice->paid_at->format('M d, Y') }}</p>
                            @endif
                        @else
                            <span class="badge bg-warning-transparent fs-6">{{ __('messages.unpaid') ?? 'Unpaid' }}</span>
                        @endif
                    </div>

                    <hr>

                    <p class="text-muted">{{ __('messages.created') ?? 'Created' }}</p>
                    <p>{{ $invoice->created_at->format('M d, Y \a\t H:i') }}</p>

                    <p class="text-muted">{{ __('messages.last_updated') ?? 'Last Updated' }}</p>
                    <p>{{ $invoice->updated_at->format('M d, Y \a\t H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
