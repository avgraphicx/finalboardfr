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
    {{-- <ul>x
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
            <div class="card custom-card widget-cardt success">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3 flex-wrap">
                        <div class="lh-1">
                            <span class="avatar avatar-md bg-success">
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
            <div class="card custom-card widget-cardt success">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3 flex-wrap">
                        <div class="lh-1">
                            <span class="avatar avatar-md bg-success">
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

    <!-- Start::row-2 -->
    <div class="row row-cols-xxl-5">
        <div class="col">
            <div class="card custom-card widget-cardt success">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3 flex-wrap">
                        <div class="lh-1">
                            <span class="avatar avatar-md bg-success">
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
            <div class="card custom-card widget-cardt success">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3 flex-wrap">
                        <div class="lh-1">
                            <span class="avatar avatar-md bg-success">
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
            <div class="card custom-card widget-cardt danger">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3 flex-wrap">
                        <div class="lh-1">
                            <span class="avatar avatar-md bg-danger">
                                <i class="ri-user-unfollow-fill fs-5"></i>
                            </span>
                        </div>

                        <div class="flex-fill">
                            <span class="d-block">{{ __('messages.drivers_missing_ssn') }}</span>
                            <h5 class="fw-semibold">{{ $stats['drivers_missing_ssn'] }}</h5>
                        </div>
                        {{-- <div class="fs-15 text-success">{{ $stats['active_driver_percentage'] }}%</div> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card custom-card widget-cardt danger">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3 flex-wrap">
                        <div class="lh-1">
                            <span class="avatar avatar-md bg-danger">
                                <i class="ri-user-unfollow-fill fs-5"></i>
                            </span>
                        </div>

                        <div class="flex-fill">
                            <span class="d-block">{{ __('messages.drivers_missing_license') }}</span>
                            <h5 class="fw-semibold">{{ $stats['drivers_missing_license'] }}</h5>
                        </div>
                        {{-- <div class="fs-15 text-success">{{ $stats['active_driver_percentage'] }}%</div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card custom-card widget-cardt success">
                <div class="card-body">
                    <div class="d-flex align-items-start gap-3 flex-wrap">
                        <div class="lh-1">
                            <span class="avatar avatar-md bg-success">
                                <i class="ri-bill-line fs-5"></i>
                            </span>
                        </div>

                        <div class="flex-fill">
                            <span class="d-block">{{ __('messages.total_unpaid_invoices') }}</span>
                            <h5 class="fw-semibold">{{ $stats['unpaid_invoices'] }}</h5>
                        </div>
                        {{-- <div class="fs-15 text-success">{{ $stats['active_driver_percentage'] }}%</div> --}}
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!--End::row-2 -->

    <!--Start::row-3 -->
    <div class="row">
        @if (!empty($stats['top_driver']))
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="card custom-card widget-cardl lavenderx">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <div class="flex-fill">
                                <div class="mb-2">{{ __('messages.top_driver_days') }}</div>
                                <a href="drivers/{{ $stats['top_driver']['driver']->id }}">
                                    <h4 class="fw-semibold lavenderx mb-0">{{ $stats['top_driver']['driver']->full_name }}
                                    </h4>
                                </a>
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
                <div class="card custom-card widget-cardl success">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <div class="flex-fill">
                                <div class="mb-2">{{ __('messages.top_driver_int') }}</div>
                                <h4 class="fw-semibold success mb-0">
                                    {{ $stats['top_driver_int']['driver']->full_name }}
                                </h4>
                            </div>
                            <div>
                                <span class="avatar avatar-md bg-success">
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
                <div class="card custom-card widget-cardl success">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <div class="flex-fill">
                                <div class="mb-2">{{ __('messages.top_driver_own') }}</div>
                                <h4 class="fw-semibold success mb-0">
                                    {{ $stats['top_driver_own']['driver']->full_name }}
                                </h4>
                            </div>
                            <div>
                                <span class="avatar avatar-md bg-success">
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
    <!--End::row-3 -->

    <!--Start::row-4 -->
    <div class="col-12">
        <div class="card custom-card widget-cardt mintx">
            <div class="card-header">
                <div class="card-title">{{ __('messages.broker_weekly_earnings') }}</div>
            </div>
            <div class="card-body">
                <div id="zoom-chart"></div>
            </div>
        </div>
    </div>
    <!--End::row-4 -->
@endsection

@section('scripts')
    <script src="{{ asset('build/assets/libs/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('build/assets/apexcharts-line-DekI3owz.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Prepare data for broker earnings by week
            var earningsData = @json($stats['broker_earnings_by_week']);
            // Extract categories (weeks) and series values
            var weeks = earningsData.map(function (item) {
                return item.week_number;
            });
            var earnings = earningsData.map(function (item) {
                return item.earnings;
            });

            var options = {
                chart: {
                    type: 'area',
                    height: 350,
                    zoom: {
                        enabled: true
                    }
                },
                series: [{
                    name: '{{ __('messages.broker_earnings') }}',
                    data: earnings
                }],
                xaxis: {
                    categories: weeks,
                    title: {
                        text: '{{ __('messages.week') }}'
                    }
                },
                yaxis: {
                    title: {
                        text: '{{ __('messages.earnings') }}'
                    },
                    labels: {
                        formatter: function (val) {
                            return '$' + val;
                        }
                    }
                },
                title: {
                    text: '',
                    align: 'left'
                },
            };
            var chart = new ApexCharts(document.querySelector("#zoom-chart"), options);
            chart.render();
        });
    </script>
@endsection
