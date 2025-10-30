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
    <!-- Controls: date range + granularity -->
    <form id="dashboard-filter" class="mb-3" method="get" action="{{ url()->current() }}">
        <div class="row g-2 align-items-center">
            <div class="col-auto">
                <label class="form-label mb-0">{{ __('messages.search_by_date') }}</label>
            </div>
            <div class="col-auto">
                <input type="date" name="from" class="form-control" value="{{ $from ?? '' }}">
            </div>
            <div class="col-auto">
                <input type="date" name="to" class="form-control" value="{{ $to ?? '' }}">
            </div>
            <div class="col-auto">
                <select name="granularity" class="form-select">
                    <option value="day" {{ isset($granularity) && $granularity == 'day' ? 'selected' : '' }}>
                        {{ __('messages.day') }}</option>
                    <option value="week" {{ !isset($granularity) || $granularity == 'week' ? 'selected' : '' }}>
                        {{ __('messages.week') }}</option>
                    <option value="month" {{ isset($granularity) && $granularity == 'month' ? 'selected' : '' }}>
                        {{ __('messages.month') }}</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">{{ __('messages.filters') }}</button>
            </div>
        </div>
    </form>
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
    @php
        $rowA = [
            [
                'label' => __('messages.total_drivers'),
                'value' => $stats['total_drivers'] ?? 0,
                'color' => 'primary',
                'icon' => 'ri-car-fill',
            ],
            [
                'label' => __('messages.active_drivers'),
                'value' => $stats['active_drivers'] ?? 0,
                'color' => 'primary',
                'icon' => 'ri-car-fill',
                'meta' => ($stats['active_driver_percentage'] ?? 0) . '%',
            ],
            [
                'label' => __('messages.total_parcels_delivered'),
                'value' => $stats['total_parcels'] ?? 0,
                'color' => 'warning',
                'icon' => 'ri-box-3-fill',
            ],
            [
                'label' => __('messages.total_intelcom_invoices'),
                'value' => $stats['total_invoice_amount'] ?? 0,
                'color' => 'success',
                'icon' => 'ri-receipt-line',
                'is_money' => true,
            ],
        ];

        $rowB = [
            [
                'label' => __('messages.total_own_invoices'),
                'value' => $stats['total_final_amount'] ?? 0,
                'color' => 'success',
                'icon' => 'ri-bill-line',
                'is_money' => true,
            ],
            [
                'label' => __('messages.avg_broker_percentage'),
                'value' => $stats['avg_broker_percentage'] ?? 0,
                'color' => 'success',
                'icon' => 'ri-discount-percent-fill',
                'meta' => '%',
            ],
            [
                'label' => __('messages.avg_vehicule_rental_price'),
                'value' => $stats['avg_vehicule_rental_price'] ?? 0,
                'color' => 'success',
                'icon' => 'ri-money-dollar-circle-fill',
                'is_money' => true,
            ],
            [
                'label' => __('messages.drivers_missing_ssn'),
                'value' => $stats['drivers_missing_ssn'] ?? 0,
                'color' => 'danger',
                'icon' => 'ri-user-unfollow-fill',
            ],
        ];
    @endphp

    <div class="row">
        @foreach ($rowA as $card)
            <div class="col-md-6 col-lg-6 col-xl-3 mb-3">
                @include('components.dashboard-card', [
                    'label' => $card['label'],
                    'value' => $card['value'],
                    'meta' => $card['meta'] ?? null,
                    'color' => $card['color'] ?? 'primary',
                    'icon' => $card['icon'] ?? null,
                    'is_money' => $card['is_money'] ?? false,
                ])
            </div>
        @endforeach
    </div>

    <div class="row">
        @foreach ($rowB as $card)
            <div class="col-md-6 col-lg-6 col-xl-3 mb-3">
                @include('components.dashboard-card', [
                    'label' => $card['label'],
                    'value' => $card['value'],
                    'meta' => $card['meta'] ?? null,
                    'color' => $card['color'] ?? 'primary',
                    'icon' => $card['icon'] ?? null,
                    'is_money' => $card['is_money'] ?? false,
                ])
            </div>
        @endforeach
    </div>
    <!--End::row-2 -->

    <!-- Start::row-3 -->
    <div class="row">
        <div class="col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card widget-cardl danger">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <div class="flex-fill">
                            <div class="mb-2">{{ __('messages.drivers_missing_license') }}</div>
                            <h4 class="fw-semibold danger mb-0">{{ $stats['drivers_missing_license'] }}</h4>
                        </div>
                        <div>
                            <span class="avatar avatar-md bg-danger">
                                <i class="ri-user-unfollow-fill fs-5"></i>
                            </span>
                        </div>
                    </div>
                    <div class="text-muted">&nbsp;</div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card widget-cardl success">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <div class="flex-fill">
                            <div class="mb-2">{{ __('messages.total_unpaid_invoices') }}</div>
                            <h4 class="fw-semibold success mb-0">{{ $stats['unpaid_invoices'] }}</h4>
                        </div>
                        <div>
                            <span class="avatar avatar-md bg-success">
                                <i class="ri-bill-line fs-5"></i>
                            </span>
                        </div>
                    </div>
                    <div class="text-muted">&nbsp;</div>
                </div>
            </div>
        </div>

        <!-- Total broker earnings -->
        <div class="col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card widget-cardl info">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <div class="flex-fill">
                            <div class="mb-2">{{ __('messages.total_broker_earnings') }}</div>
                            <h4 class="fw-semibold info mb-0">${{ $stats['total_broker_earnings'] ?? 0 }}</h4>
                        </div>
                        <div>
                            <span class="avatar avatar-md bg-info">
                                <i class="ri-wallet-3-fill fs-5"></i>
                            </span>
                        </div>
                    </div>
                    <div class="text-muted">&nbsp;</div>
                </div>
            </div>
        </div>

        <!-- Total payments (count) -->
        <div class="col-md-6 col-lg-6 col-xl-3">
            <div class="card custom-card widget-cardl secondary">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-2">
                        <div class="flex-fill">
                            <div class="mb-2">{{ __('messages.total_paid_payments') }}</div>
                            <h4 class="fw-semibold secondary mb-0">
                                ${{ number_format($stats['paid_payments_amount'] ?? 0, 2) }}</h4>
                        </div>
                        <div>
                            <span class="avatar avatar-md bg-secondary">
                                <i class="ri-file-list-3-line fs-5"></i>
                            </span>
                        </div>
                    </div>
                    <div class="text-muted">&nbsp;</div>
                </div>
            </div>
        </div>
    </div>
    <!--End::row-3 -->

    <!--Start::row-4 (top drivers) -->
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
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!--End::row-4 -->

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
        document.addEventListener('DOMContentLoaded', function() {
            // Prepare data for broker earnings by period (day/week/month)
            var earningsData = @json($stats['broker_earnings_by_period']);
            // Extract categories (period labels) and series values
            var weeks = earningsData.map(function(item) {
                return item.period;
            });
            var earnings = earningsData.map(function(item) {
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
                        formatter: function(val) {
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
