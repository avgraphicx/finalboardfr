@extends('layouts.master')

@section('content')
    <!-- Start::page-header -->
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.edit_driver') ?? 'Edit Driver' }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('drivers.index') }}">{{ __('messages.drivers') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.edit') }}</li>
            </ol>
        </div>
    </div>
    <!-- End::page-header -->

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">{{ $driver->full_name }}</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('drivers.update', $driver) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="driver_id" class="form-label">{{ __('messages.driver_id') ?? 'Driver ID' }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('driver_id') is-invalid @enderror"
                                id="driver_id" name="driver_id" value="{{ old('driver_id', $driver->driver_id) }}" required>
                            @error('driver_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="full_name" class="form-label">{{ __('messages.full_name') ?? 'Full Name' }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                id="full_name" name="full_name" value="{{ old('full_name', $driver->full_name) }}"
                                required>
                            @error('full_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="license_number"
                                class="form-label">{{ __('messages.license_number') ?? 'License Number' }}</label>
                            <input type="text" class="form-control @error('license_number') is-invalid @enderror"
                                id="license_number" name="license_number"
                                value="{{ old('license_number', $driver->license_number) }}">
                            @error('license_number')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ssn" class="form-label">{{ __('messages.ssn') ?? 'SSN' }}</label>
                            <input type="text" class="form-control @error('ssn') is-invalid @enderror" id="ssn"
                                name="ssn" value="{{ old('ssn', $driver->ssn) }}">
                            @error('ssn')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="default_percentage"
                                    class="form-label">{{ __('messages.default_percentage') ?? 'Default %' }}</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('default_percentage') is-invalid @enderror"
                                    id="default_percentage" name="default_percentage"
                                    value="{{ old('default_percentage', rtrim(rtrim(number_format($driver->default_percentage, 2, '.', ''), '0'), '.')) }}">

                                @error('default_percentage')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="default_rental_price"
                                    class="form-label">{{ __('messages.default_rental_price') ?? 'Default Rental Price' }}</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('default_rental_price') is-invalid @enderror"
                                    id="default_rental_price" name="default_rental_price"
                                    value="{{ old('default_rental_price', rtrim(rtrim(number_format($driver->default_rental_price, 2, '.', ''), '0'), '.')) }}">

                                @error('default_rental_price')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('drivers.show', $driver) }}" class="btn btn-danger"><i
                                    class="ri-close-large-fill"></i> {{ __('messages.cancel') ?? 'Cancel' }}</a>
                            <button type="submit" class="btn btn-primary">{{ __('messages.update') ?? 'Update' }}
                                <i class="ri-refresh-line"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
