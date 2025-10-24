@extends('layouts.master')

@section('content')
    <!-- Start::page-header -->
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.edit_invoice') ?? 'Edit Invoice' }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">{{ __('messages.invoices') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.edit') }}</li>
            </ol>
        </div>
    </div>
    <!-- End::page-header -->

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">{{ __('messages.invoice') ?? 'Invoice' }} #{{ $invoice->id }}</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('invoices.update', $invoice) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="alert alert-info">
                            <strong>{{ __('messages.driver') }}:</strong> {{ $invoice->driver->full_name ?? 'N/A' }} |
                            <strong>{{ __('messages.week') }}:</strong> {{ $invoice->week_number }}
                        </div>

                        <div class="mb-3">
                            <label for="invoice_total"
                                class="form-label">{{ __('messages.invoice_total') ?? 'Invoice Total' }} <span
                                    class="text-danger">*</span></label>
                            <input type="number" step="0.01"
                                class="form-control @error('invoice_total') is-invalid @enderror" id="invoice_total"
                                name="invoice_total" value="{{ old('invoice_total', $invoice->invoice_total) }}" required>
                            @error('invoice_total')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="total_parcels"
                                    class="form-label">{{ __('messages.total_parcels') ?? 'Total Parcels' }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('total_parcels') is-invalid @enderror"
                                    id="total_parcels" name="total_parcels"
                                    value="{{ old('total_parcels', $invoice->total_parcels) }}" required>
                                @error('total_parcels')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="days_worked"
                                    class="form-label">{{ __('messages.days_worked') ?? 'Days Worked' }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('days_worked') is-invalid @enderror"
                                    id="days_worked" name="days_worked"
                                    value="{{ old('days_worked', $invoice->days_worked) }}" required>
                                @error('days_worked')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="vehicle_rental_price"
                                    class="form-label">{{ __('messages.vehicle_rental_price') ?? 'Vehicle Rental Price' }}</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('vehicle_rental_price') is-invalid @enderror"
                                    id="vehicle_rental_price" name="vehicle_rental_price"
                                    value="{{ old('vehicle_rental_price', $invoice->vehicle_rental_price) }}">
                                @error('vehicle_rental_price')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="driver_percentage"
                                    class="form-label">{{ __('messages.driver_percentage') ?? 'Driver %' }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="0.01"
                                    class="form-control @error('driver_percentage') is-invalid @enderror"
                                    id="driver_percentage" name="driver_percentage"
                                    value="{{ old('driver_percentage', $invoice->driver_percentage) }}" required>
                                @error('driver_percentage')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="bonus" class="form-label">{{ __('messages.bonus') ?? 'Bonus' }}</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('bonus') is-invalid @enderror" id="bonus" name="bonus"
                                    value="{{ old('bonus', $invoice->bonus) }}">
                                @error('bonus')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="cash_advance"
                                    class="form-label">{{ __('messages.cash_advance') ?? 'Cash Advance' }}</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('cash_advance') is-invalid @enderror" id="cash_advance"
                                    name="cash_advance" value="{{ old('cash_advance', $invoice->cash_advance) }}">
                                @error('cash_advance')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="penalty" class="form-label">{{ __('messages.penalty') ?? 'Penalty' }}</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('penalty') is-invalid @enderror" id="penalty"
                                    name="penalty" value="{{ old('penalty', $invoice->penalty) }}">
                                @error('penalty')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="is_paid"
                                    class="form-label">{{ __('messages.payment_status') ?? 'Payment Status' }}</label>
                                <select class="form-control" id="is_paid" name="is_paid">
                                    <option value="0" {{ old('is_paid', $invoice->is_paid) == 0 ? 'selected' : '' }}>
                                        {{ __('messages.unpaid') ?? 'Unpaid' }}</option>
                                    <option value="1" {{ old('is_paid', $invoice->is_paid) == 1 ? 'selected' : '' }}>
                                        {{ __('messages.paid') ?? 'Paid' }}</option>
                                </select>
                            </div>
                        </div>

                        @if ($invoice->is_paid)
                            <div class="mb-3">
                                <label for="paid_at"
                                    class="form-label">{{ __('messages.paid_at') ?? 'Paid At' }}</label>
                                <input type="date" class="form-control @error('paid_at') is-invalid @enderror"
                                    id="paid_at" name="paid_at"
                                    value="{{ old('paid_at', $invoice->paid_at?->format('Y-m-d')) }}">
                                @error('paid_at')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('invoices.show', $invoice) }}"
                                class="btn btn-secondary">{{ __('messages.cancel') ?? 'Cancel' }}</a>
                            <button type="submit"
                                class="btn btn-primary">{{ __('messages.update') ?? 'Update' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
