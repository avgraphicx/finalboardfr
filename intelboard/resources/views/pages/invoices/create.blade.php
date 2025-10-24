@extends('layouts.master')

@section('content')
    <!-- Start::page-header -->
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.create_invoice') ?? 'Create Invoice' }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">{{ __('messages.invoices') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.create') }}</li>
            </ol>
        </div>
    </div>
    <!-- End::page-header -->

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">{{ __('messages.invoice_details') ?? 'Invoice Details' }}</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('invoices.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="driver_id" class="form-label">{{ __('messages.driver') ?? 'Driver' }} <span
                                    class="text-danger">*</span></label>
                            <select class="form-control @error('driver_id') is-invalid @enderror" id="driver_id"
                                name="driver_id" required>
                                <option value="">{{ __('messages.select_driver') ?? 'Select Driver' }}</option>
                                @foreach ($drivers as $driver)
                                    <option value="{{ $driver->id }}"
                                        {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                        {{ $driver->driver_id }} - {{ $driver->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('driver_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="week_number" class="form-label">{{ __('messages.week') ?? 'Week #' }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('week_number') is-invalid @enderror"
                                    id="week_number" name="week_number" value="{{ old('week_number', now()->weekOfYear) }}"
                                    required>
                                @error('week_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="warehouse_name"
                                    class="form-label">{{ __('messages.warehouse') ?? 'Warehouse' }}</label>
                                <input type="text" class="form-control @error('warehouse_name') is-invalid @enderror"
                                    id="warehouse_name" name="warehouse_name" value="{{ old('warehouse_name') }}">
                                @error('warehouse_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="invoice_total"
                                    class="form-label">{{ __('messages.invoice_total') ?? 'Invoice Total' }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="0.01"
                                    class="form-control @error('invoice_total') is-invalid @enderror" id="invoice_total"
                                    name="invoice_total" value="{{ old('invoice_total', 0) }}" required>
                                @error('invoice_total')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="total_parcels"
                                    class="form-label">{{ __('messages.total_parcels') ?? 'Total Parcels' }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('total_parcels') is-invalid @enderror"
                                    id="total_parcels" name="total_parcels" value="{{ old('total_parcels', 0) }}" required>
                                @error('total_parcels')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="days_worked"
                                    class="form-label">{{ __('messages.days_worked') ?? 'Days Worked' }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('days_worked') is-invalid @enderror"
                                    id="days_worked" name="days_worked" value="{{ old('days_worked', 0) }}" required>
                                @error('days_worked')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="vehicle_rental_price"
                                    class="form-label">{{ __('messages.vehicle_rental_price') ?? 'Vehicle Rental Price' }}</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('vehicle_rental_price') is-invalid @enderror"
                                    id="vehicle_rental_price" name="vehicle_rental_price"
                                    value="{{ old('vehicle_rental_price', 0) }}">
                                @error('vehicle_rental_price')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="driver_percentage"
                                    class="form-label">{{ __('messages.driver_percentage') ?? 'Driver %' }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="0.01"
                                    class="form-control @error('driver_percentage') is-invalid @enderror"
                                    id="driver_percentage" name="driver_percentage"
                                    value="{{ old('driver_percentage', 0) }}" required>
                                @error('driver_percentage')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="bonus" class="form-label">{{ __('messages.bonus') ?? 'Bonus' }}</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('bonus') is-invalid @enderror" id="bonus"
                                    name="bonus" value="{{ old('bonus', 0) }}">
                                @error('bonus')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cash_advance"
                                    class="form-label">{{ __('messages.cash_advance') ?? 'Cash Advance' }}</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('cash_advance') is-invalid @enderror" id="cash_advance"
                                    name="cash_advance" value="{{ old('cash_advance', 0) }}">
                                @error('cash_advance')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="penalty"
                                    class="form-label">{{ __('messages.penalty') ?? 'Penalty' }}</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('penalty') is-invalid @enderror" id="penalty"
                                    name="penalty" value="{{ old('penalty', 0) }}">
                                @error('penalty')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('invoices.index') }}"
                                class="btn btn-secondary">{{ __('messages.cancel') ?? 'Cancel' }}</a>
                            <button type="submit"
                                class="btn btn-primary">{{ __('messages.create') ?? 'Create' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
