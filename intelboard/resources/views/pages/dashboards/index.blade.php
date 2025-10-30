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
    @php
        $filterDefaults = [
            'period' => 'weekly',
            'start_date' => now()->startOfWeek()->toDateString(),
            'end_date' => now()->endOfWeek()->toDateString(),
        ];
        $filterData = array_merge($filterDefaults, $stats['time_filter'] ?? []);
@endphp

    @if ($canUseAdvancedFilters)
        <form method="GET" action="{{ route('index') }}" class="card custom-card mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="time-period" class="form-label">{{ __('messages.filter_period') }}</label>
                        <select name="period" id="time-period" class="form-select">
                            <option value="daily" {{ $filterData['period'] === 'daily' ? 'selected' : '' }}>
                                {{ __('messages.filter_daily') }}
                            </option>
                            <option value="weekly" {{ $filterData['period'] === 'weekly' ? 'selected' : '' }}>
                                {{ __('messages.filter_weekly') }}
                            </option>
                            <option value="monthly" {{ $filterData['period'] === 'monthly' ? 'selected' : '' }}>
                                {{ __('messages.filter_monthly') }}
                            </option>
                            <option value="range" {{ $filterData['period'] === 'range' ? 'selected' : '' }}>
                                {{ __('messages.filter_range') }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4 {{ $filterData['period'] !== 'range' ? 'd-none' : '' }}" id="custom-range-fields">
                        <div class="row g-2">
                            <div class="col-6">
                                <label for="start-date" class="form-label">{{ __('messages.filter_from') }}</label>
                                <input type="date" name="start_date" id="start-date" class="form-control"
                                    value="{{ $filterData['start_date'] }}">
                            </div>
                            <div class="col-6">
                                <label for="end-date" class="form-label">{{ __('messages.filter_to') }}</label>
                                <input type="date" name="end_date" id="end-date" class="form-control"
                                    value="{{ $filterData['end_date'] }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">{{ __('messages.filter_apply') }}</button>
                    </div>
                </div>
            </div>
        </form>
    @endif

    @php
        $complianceCards = [
            [
                'title' => __('messages.drivers_missing_ssn'),
                'value' => number_format($stats['drivers_missing_ssn'] ?? 0),
                'icon' => 'ri-user-unfollow-fill',
                'color' => 'danger',
            ],
            [
                'title' => __('messages.drivers_missing_license'),
                'value' => number_format($stats['drivers_missing_license'] ?? 0),
                'icon' => 'ri-user-unfollow-fill',
                'color' => 'danger',
            ],
        ];

        $driverCards = [
            [
                'title' => __('messages.active_vs_total_drivers'),
                'value' => number_format($stats['active_drivers'] ?? 0) . ' / ' . number_format($stats['total_drivers'] ?? 0),
                'icon' => 'ri-steering-2-fill',
                'color' => 'primary',
                'hint' => number_format($stats['active_driver_percentage'] ?? 0, 1) . '%',
            ],
        ];

        $parcelCards = [
            [
                'title' => __('messages.total_parcels_delivered'),
                'value' => number_format($stats['total_parcels'] ?? 0),
                'icon' => 'ri-box-3-fill',
                'color' => 'warning',
            ],
        ];

        $financeCards = [
            [
                'title' => __('messages.total_intelcom_invoices'),
                'value' => '$' . number_format($stats['total_invoice_amount'] ?? 0, 2),
                'icon' => 'ri-receipt-line',
                'color' => 'success',
            ],
            [
                'title' => __('messages.total_own_invoices'),
                'value' => '$' . number_format($stats['total_final_amount'] ?? 0, 2),
                'icon' => 'ri-bill-line',
                'color' => 'success',
            ],
            [
                'title' => __('messages.avg_broker_percentage'),
                'value' => number_format($stats['avg_broker_percentage'] ?? 0, 2) . '%',
                'icon' => 'ri-discount-percent-fill',
                'color' => 'success',
            ],
            [
                'title' => __('messages.avg_vehicule_rental_price'),
                'value' => '$' . number_format($stats['avg_vehicule_rental_price'] ?? 0, 2),
                'icon' => 'ri-money-dollar-circle-fill',
                'color' => 'success',
            ],
            [
                'title' => __('messages.total_broker_earnings'),
                'value' => '$' . number_format($stats['total_broker_earnings'] ?? 0, 2),
                'icon' => 'ri-wallet-3-fill',
                'color' => 'info',
            ],
            [
                'title' => __('messages.total_payments'),
                'value' => number_format($stats['paid_payments'] ?? 0),
                'icon' => 'ri-file-list-3-line',
                'color' => 'secondary',
            ],
            [
                'title' => __('messages.total_unpaid_invoices'),
                'value' => number_format($stats['unpaid_invoices'] ?? 0),
                'icon' => 'ri-bill-line',
                'color' => 'secondary',
            ],
        ];

        $metricCards = array_merge($complianceCards, $driverCards, $parcelCards, $financeCards);

        $topDriverCards = [];

        if (!empty($stats['top_driver'])) {
            $topDriverCards[] = [
                'title' => __('messages.top_driver_days'),
                'value' => $stats['top_driver']['driver']->full_name,
                'icon' => 'ri-user-star-fill',
                'color' => 'lavenderx',
                'hint' => number_format($stats['top_driver']['total_rows'] ?? 0) . ' ' . __('messages.days'),
                'href' => url('drivers/' . $stats['top_driver']['driver']->id),
            ];
        }

        if (!empty($stats['top_driver_parcels'])) {
            $topDriverCards[] = [
                'title' => __('messages.top_driver_parcels'),
                'value' => $stats['top_driver_parcels']['driver']->full_name,
                'icon' => 'ri-user-star-fill',
                'color' => 'warning',
                'hint' => number_format($stats['top_driver_parcels']['total_parcels'] ?? 0) . ' ' . __('messages.parcels'),
            ];
        }

        if (!empty($stats['top_driver_int'])) {
            $topDriverCards[] = [
                'title' => __('messages.top_driver_int'),
                'value' => $stats['top_driver_int']['driver']->full_name,
                'icon' => 'ri-receipt-line',
                'color' => 'success',
                'hint' => '$' . number_format($stats['top_driver_int']['total_invoice'] ?? 0, 2),
            ];
        }

        if (!empty($stats['top_driver_own'])) {
            $topDriverCards[] = [
                'title' => __('messages.top_driver_own'),
                'value' => $stats['top_driver_own']['driver']->full_name,
                'icon' => 'ri-receipt-line',
                'color' => 'success',
                'hint' => '$' . number_format($stats['top_driver_own']['final_amount'] ?? 0, 2),
            ];
        }
    @endphp

    @foreach (collect($metricCards)->chunk(4) as $chunk)
        <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3 mb-3">
            @foreach ($chunk as $card)
                <div class="col">
                    <x-dashboard-card :title="$card['title']" :value="$card['value']" :icon="$card['icon']" :color="$card['color']"
                        :hint="$card['hint'] ?? null" :href="$card['href'] ?? null" />
                </div>
            @endforeach
        </div>
    @endforeach

    @if (!empty($topDriverCards))
        @foreach (collect($topDriverCards)->chunk(4) as $chunk)
            <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-4 g-3 mb-3">
                @foreach ($chunk as $card)
                    <div class="col">
                        <x-dashboard-card :title="$card['title']" :value="$card['value']" :icon="$card['icon']" :color="$card['color']"
                            :hint="$card['hint'] ?? null" :href="$card['href'] ?? null" />
                    </div>
                @endforeach
            </div>
        @endforeach
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card custom-card widget-cardt mintx">
                <div class="card-header">
                    <div class="card-title">{{ __('messages.broker_earnings_over_time') }}</div>
                </div>
                <div class="card-body">
                    <div id="zoom-chart"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('build/assets/libs/apexcharts/apexcharts.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var periodSelect = document.getElementById('time-period');
            var rangeFields = document.getElementById('custom-range-fields');

            if (periodSelect && rangeFields) {
                var toggleRangeFields = function() {
                    if (periodSelect.value === 'range') {
                        rangeFields.classList.remove('d-none');
                    } else {
                        rangeFields.classList.add('d-none');
                    }
                };
                toggleRangeFields();
                periodSelect.addEventListener('change', toggleRangeFields);
            }

            // Prepare data for broker earnings over selected period
            var earningsData = @json($stats['broker_earnings_series']);

            var labels = earningsData.map(function(item) {
                return item.label;
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
                    categories: labels,
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
