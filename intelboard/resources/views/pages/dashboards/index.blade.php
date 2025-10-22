@extends('layouts.master')

@section('styles')
@endsection

@section('content')
    <!-- Start::page-header -->
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.stats') }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.dashboard') }}</li>
            </ol>
        </div>
    </div>
    <!-- End::page-header -->
    {{-- <ul>
            <li>Total Drivers: {{ $stats['total_drivers'] }}</li>
            <li>Total Payments: {{ $stats['total_payments'] }}</li>
            <li>Total Invoice Amount: ${{ number_format($stats['total_invoice_amount'], 2) }}</li>
            <li>Total Parcels: {{ $stats['total_parcels'] }}</li>
            <li>Average Final Amount: ${{ $stats['avg_final_amount'] }}</li>
            <li>Total Broker Earnings: ${{ $stats['total_broker_earnings'] }}</li>
            <li>Unpaid Payments: {{ $stats['unpaid_payments'] }}</li>
            <li>Paid Payments: {{ $stats['paid_payments'] }}</li>
            <li>Top Driver:
                @if ($stats['top_driver'])
                    {{ $stats['top_driver']->driver_id }}
                    ({{ $stats['top_driver']->total_rows }} parcels)
                @else
                    None
                @endif
            </li>
        </ul> --}}
    <!-- Start::row-1 -->
    <div class="row row-cols-xxl-5">
        <div class="col">
            <div class="card custom-card widget-cardt primary">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3 flex-wrap">
                        <div class="lh-1">
                            <span class="avatar avatar-md bg-primary">
                                <i class="ri-car-fill fs-5"></i>
                            </span>
                        </div>
                        <div class="flex-fill">
                            <span class="d-block">{{ __('messages.total_drivers') }}</span>
                            <h5 class="fw-semibold">{{ $stats['total_drivers'] }}</h5>
                            {{-- <span class="badge bg-primary-transparent">{{ __('messages.payments') }}:
                                {{ $allStats['paymentStats']['totalPayments'] }}</span> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card custom-card widget-cardt primary">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3 flex-wrap">
                        <div class="lh-1">
                            <span class="avatar avatar-md bg-primary">
                                <i class="ri-car-fill fs-5"></i>
                            </span>
                        </div>
                        <div class="flex-fill">
                            <span class="d-block">{{ __('messages.active_drivers') }}</span>
                            <h5 class="fw-semibold">{{ $stats['active_drivers'] }}</h5>
                        </div>
                        <div class="fs-15 text-success">{{ $stats['active_driver_percentage'] }}%</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card custom-card widget-cardt warning">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3 flex-wrap">
                        <div class="lh-1">
                            <span class="avatar avatar-md bg-warning">
                                <i class="ri-box-3-fill fs-5"></i>
                            </span>
                        </div>

                        <div class="flex-fill">
                            <span class="d-block">{{ __('messages.total_parcels_delivered') }}</span>
                            <h5 class="fw-semibold">{{ $stats['total_parcels'] }}</h5>
                        </div>
                        {{-- <div class="fs-15 text-success">{{ $stats['active_driver_percentage'] }}%</div> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card custom-card widget-cardt falconx">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3 flex-wrap">
                        <div class="lh-1">
                            <span class="avatar avatar-md bg-falconx">
                                <i class="ri-receipt-line fs-5"></i>
                            </span>
                        </div>

                        <div class="flex-fill">
                            <span class="d-block">{{ __('messages.total_intelcom_invoices') }}</span>
                            <h5 class="fw-semibold">{{ $stats['total_invoice_amount'] }}$</h5>
                        </div>
                        {{-- <div class="fs-15 text-success">{{ $stats['active_driver_percentage'] }}%</div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card custom-card widget-cardt falconx">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3 flex-wrap">
                        <div class="lh-1">
                            <span class="avatar avatar-md bg-falconx">
                                <i class="ri-bill-line fs-5"></i>
                            </span>
                        </div>

                        <div class="flex-fill">
                            <span class="d-block">{{ __('messages.total_own_invoices') }}</span>
                            <h5 class="fw-semibold">{{ $stats['total_final_amount'] }}$</h5>
                        </div>
                        {{-- <div class="fs-15 text-success">{{ $stats['active_driver_percentage'] }}%</div> --}}
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!--End::row-1 -->
    <div class="row row-cols-xxl-5">
        <div class="col">
            <div class="card custom-card widget-cardt falconx">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3 flex-wrap">
                        <div class="lh-1">
                            <span class="avatar avatar-md bg-falconx">
                                <i class="ri-discount-percent-fill fs-5"></i>
                            </span>
                        </div>
                        <div class="flex-fill">
                            <span class="d-block">{{ __('messages.avg_broker_percentage') }}</span>
                            <h5 class="fw-semibold">{{ $stats['avg_broker_percentage'] }}%</h5>
                            {{-- <span class="badge bg-primary-transparent">{{ __('messages.payments') }}:
                                {{ $allStats['paymentStats']['totalPayments'] }}</span> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card custom-card widget-cardt falconx">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3 flex-wrap">
                        <div class="lh-1">
                            <span class="avatar avatar-md bg-falconx">
                                <i class="ri-money-dollar-circle-fill fs-5"></i>
                            </span>
                        </div>
                        <div class="flex-fill">
                            <span class="d-block">{{ __('messages.avg_vehicule_rental_price') }}</span>
                            <h5 class="fw-semibold">{{ $stats['avg_vehicule_rental_price'] }}$</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card custom-card widget-cardt warning">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3 flex-wrap">
                        <div class="lh-1">
                            <span class="avatar avatar-md bg-warning">
                                <i class="ri-box-3-fill fs-5"></i>
                            </span>
                        </div>

                        <div class="flex-fill">
                            <span class="d-block">{{ __('messages.total_parcels_delivered') }}</span>
                            <h5 class="fw-semibold">{{ $stats['total_parcels'] }}</h5>
                        </div>
                        {{-- <div class="fs-15 text-success">{{ $stats['active_driver_percentage'] }}%</div> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card custom-card widget-cardt falconx">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3 flex-wrap">
                        <div class="lh-1">
                            <span class="avatar avatar-md bg-falconx">
                                <i class="ri-receipt-line fs-5"></i>
                            </span>
                        </div>

                        <div class="flex-fill">
                            <span class="d-block">{{ __('messages.total_intelcom_invoices') }}</span>
                            <h5 class="fw-semibold">{{ $stats['total_invoice_amount'] }}$</h5>
                        </div>
                        {{-- <div class="fs-15 text-success">{{ $stats['active_driver_percentage'] }}%</div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card custom-card widget-cardt falconx">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3 flex-wrap">
                        <div class="lh-1">
                            <span class="avatar avatar-md bg-falconx">
                                <i class="ri-bill-line fs-5"></i>
                            </span>
                        </div>

                        <div class="flex-fill">
                            <span class="d-block">{{ __('messages.total_own_invoices') }}</span>
                            <h5 class="fw-semibold">{{ $stats['total_final_amount'] }}$</h5>
                        </div>
                        {{-- <div class="fs-15 text-success">{{ $stats['active_driver_percentage'] }}%</div> --}}
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!--End::row-1 -->

    <!--End::row-2 -->
    <div class="row">
        @if (!empty($stats['top_driver']))
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card custom-card widget-cardl lavenderx">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <div class="flex-fill">
                                <div class="mb-2">{{ __('messages.top_driver_days') }}</div>
                                <h4 class="fw-semibold lavenderx mb-0">{{ $stats['top_driver']['driver']->full_name }}
                                </h4>
                            </div>
                            <div>
                                <span class="avatar avatar-md bg-lavenderx">
                                    <i class="ri-user-star-fill fs-5"></i>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex fs-13 align-items-center justify-content-between">
                            <div class="text-muted">{{ $stats['top_driver']['total_rows'] }}
                                {{ __('messages.days') }}</div>
                            {{-- <div class="text-danger fw-medium d-inline-flex"><i
                                    class="ti ti-trending-down align-middle me-1"></i>1.07%</div> --}}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (!empty($stats['top_driver_parcels']))
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card custom-card widget-cardl warning">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <div class="flex-fill">
                                <div class="mb-2">{{ __('messages.top_driver_parcels') }}</div>
                                <h4 class="fw-semibold text-warning mb-0">
                                    {{ $stats['top_driver_parcels']['driver']->full_name }}
                                </h4>
                            </div>
                            <div>
                                <span class="avatar avatar-md bg-warning">
                                    <i class="ri-user-star-fill fs-5"></i>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex fs-13 align-items-center justify-content-between">
                            <div class="text-muted">{{ $stats['top_driver_parcels']['total_parcels'] }}
                                {{ __('messages.parcels') }}</div>
                            {{-- <div class="text-danger fw-medium d-inline-flex"><i
                                    class="ti ti-trending-down align-middle me-1"></i>1.07%</div> --}}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (!empty($stats['top_driver_int']))
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card custom-card widget-cardl falconx">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <div class="flex-fill">
                                <div class="mb-2">{{ __('messages.top_driver_int') }}</div>
                                <h4 class="fw-semibold falconx mb-0">
                                    {{ $stats['top_driver_int']['driver']->full_name }}
                                </h4>
                            </div>
                            <div>
                                <span class="avatar avatar-md bg-amberx">
                                    <i class="ri-receipt-line fs-5"></i>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex fs-13 align-items-center justify-content-between">
                            <div class="text-muted">{{ $stats['top_driver_int']['total_invoice'] }}$</div>
                            {{-- <div class="text-danger fw-medium d-inline-flex"><i
                                    class="ti ti-trending-down align-middle me-1"></i>1.07%</div> --}}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (!empty($stats['top_driver_own']))
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card custom-card widget-cardl falconx">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <div class="flex-fill">
                                <div class="mb-2">{{ __('messages.top_driver_own') }}</div>
                                <h4 class="fw-semibold falconx mb-0">
                                    {{ $stats['top_driver_own']['driver']->full_name }}
                                </h4>
                            </div>
                            <div>
                                <span class="avatar avatar-md bg-falconx">
                                    <i class="ri-receipt-line fs-5"></i>
                                </span>
                            </div>
                        </div>
                        <div class="d-flex fs-13 align-items-center justify-content-between">
                            <div class="text-muted">{{ $stats['top_driver_own']['final_amount'] }}$</div>
                            {{-- <div class="text-danger fw-medium d-inline-flex"><i
                                    class="ti ti-trending-down align-middle me-1"></i>1.07%</div> --}}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
@endsection
