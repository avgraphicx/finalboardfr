@extends('layouts.master')

@section('content')
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.driver_statistics') ?? 'Driver Statistics' }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    @if ($drivers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.driver') ?? 'Driver' }}</th>
                                        <th>{{ __('messages.total_invoices') ?? 'Total Invoices' }}</th>
                                        <th>{{ __('messages.total_parcels') ?? 'Total Parcels' }}</th>
                                        <th>{{ __('messages.earnings') ?? 'Earnings' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($drivers as $driver)
                                        <tr>
                                            <td><a href="{{ route('drivers.show', $driver) }}">{{ $driver->full_name }}</a>
                                            </td>
                                            <td>{{ $driver->invoices()->count() }}</td>
                                            <td>{{ $driver->invoices()->sum('total_parcels') }}</td>
                                            <td>${{ number_format($driver->invoices()->sum('amount_to_pay_driver'), 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">{{ __('messages.no_drivers_found') ?? 'No drivers found.' }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
