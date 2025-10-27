@extends('layouts.master')

@section('styles')
    {{-- Using modern CDN links that you provided --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.driver') }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('messages.dashboard_menu') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.driver') }}</li>
            </ol>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-xl-3">
            <div class="card custom-card dashboard-main-card primary">
                <div class="card-body text-center p-4">
                    @php
                        $nameParts = explode(' ', trim($driver->full_name));
                        $initials = '';
                        foreach ($nameParts as $part) {
                            if (!empty($part)) {
                                $initials .= strtoupper(substr($part, 0, 1));
                            }
                        }
                        $initials = substr($initials, 0, 2);
                    @endphp
                    <span class="avatar avatar-xxl avatar-rounded bg-primary text-light">
                        <span class="avatar-text fw-bold fs-5" style="color: white !important;">{{ $initials }}</span>
                        <span id="active"
                              class="badge rounded-pill  @if ($driver->active == 0) bg-danger @endif
                            @if ($driver->active == 1) bg-success @endif avatar-badge"></span>
                    </span>
                    <h6 class="fw-semibold mt-3 mb-1">{{ $driver->driver_id }} - {{ $driver->full_name }}
                        <span class="p-1">
                            <a href="#" id="editDriverBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#ffffff"
                                     viewBox="0 0 256 256">
                                    <path
                                        d="M227.31,73.37,182.63,28.68a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H92.69A15.86,15.86,0,0,0,104,219.31L227.31,96a16,16,0,0,0,0-22.63ZM92.69,208H48V163.31l88-88L180.69,120ZM192,108.68,147.31,64l24-24L216,84.68Z">
                                    </path>
                                </svg>
                            </a>
                        </span>
                    </h6>

                    <ul class="nav nav-tabs flex-column nav-tabs-header mb-0 mail-sesttings-tab" role="tablist">
                        <li class="nav-item m-1 text-success" id="protab">
                            <a href="javascript:void(0)" class="pe-none text-success fw-medium nav-link active"
                               tabindex="-1">
                                <i class="bi bi-phone me-1"></i> {{ $driver->phone_number }}
                            </a>
                        </li>
                        <li class="nav-item m-1" id="protab2">
                            <a href="javascript:void(0)" class="pe-none text-primary fw-medium nav-link" tabindex="-1">
                                <i class="bi bi-person-vcard me-1"></i> {{ $driver->license_number }}
                            </a>
                        </li>
                        <li class="nav-item m-1" id="protab2">
                            <a href="javascript:void(0)"
                               class="text-primary fw-medium nav-link cursor-pointer d-flex align-items-center gap-2">
                                <span class="ssn-value" data-ssn="{{ $driver->ssn }}">**********</span>
                                <i class="bi bi-eye ssn-toggle-icon" style="cursor: pointer;"></i>
                            </a>
                        </li>

                        <li class="nav-item m-1" id="protab2">
                            <a href="javascript:void(0)" class="pe-none text-primary fw-medium nav-link" tabindex="-1">
                                <i class="bi bi-percent me-1"></i> {{ $driver->default_percentage }}%
                            </a>
                        </li>
                        <li class="nav-item m-1" id="protab2">
                            <a href="javascript:void(0)" class="pe-none text-primary fw-medium nav-link" tabindex="-1">
                                <i class="bi bi-cash-coin me-1"></i> {{ $driver->default_rental_price }}$
                            </a>
                        </li>
                        <li class="nav-item m-1" id="protab2">
                            <a href="javascript:void(0)" class="pe-none text-primary fw-medium nav-link" tabindex="-1">
                                <i class="bi bi-person-circle me-1"></i>
                                {{ $driver->createdBy?->full_name ?? 'N/A' }}
                                - {{ $driver->created_at->toDateString() }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-9" id="latestPays">
            <div class="card custom-card dashboard-main-card success">
                <div class="card-header">
                    <div class="card-title">{{ __('messages.driver_payments') }}</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="driver-payments-table">
                            <thead>
                            <tr>
                                <th width="50">
                                    <input type="checkbox" id="select-all-payments" class="form-check-input">
                                </th>
                                <th>{{ __('messages.table_week_number') }}</th>
                                <th>{{ __('messages.table_total_invoice') }}</th>
                                <th>{{ __('messages.table_parcel_rows') }}</th>
                                <th>{{ __('messages.table_days_worked') }}</th>
                                <th>{{ __('messages.table_benefit') }}</th>
                                <th>{{ __('messages.table_final_amount') }}</th>
                                <th>{{ __('messages.table_actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($driver->invoices()->orderBy('id', 'asc')->limit(10)->get() as $invoice)
                                <tr id="invoice-row-{{ $invoice->id }}">
                                    <td>
                                        <input type="checkbox" class="form-check-input invoice-checkbox"
                                               data-invoice-id="{{ $invoice->id }}">
                                    </td>
                                    <td>
                                            <span class="badge {{ $invoice->is_paid ? 'bg-success' : 'bg-danger' }}">
                                                {{ __('messages.table_week_short') }} {{ $invoice->week_number }}
                                            </span>
                                    </td>
                                    <td>${{ number_format($invoice->invoice_total, 2) }}</td>
                                    <td>{{ $invoice->total_parcels }}</td>
                                    <td>{{ $invoice->days_worked }}</td>
                                    <td>
                                        ${{ number_format(($invoice->driver_percentage / 100) * $invoice->invoice_total, 2) }}
                                    </td>
                                    <td class="fw-bold text-success">
                                        ${{ number_format($invoice->amount_to_pay_driver, 2) }}</td>
                                    <td>
                                        <div class="hstack gap-2 fs-15">
                                            <a href="{{ route('invoices.show', $invoice->id) }}"
                                               class="btn btn-icon btn-sm btn-primary"
                                               title="{{ __('messages.btn_view') }}">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('invoices.edit', $invoice->id) }}"
                                               class="btn btn-icon btn-sm btn-warning"
                                               title="{{ __('messages.btn_edit') }}">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <button class="btn btn-icon btn-sm btn-danger delete-invoice-btn"
                                                    data-invoice-id="{{ $invoice->id }}"
                                                    title="{{ __('messages.btn_delete') }}">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>

                                            @if (!$invoice->is_paid)
                                                <button class="btn btn-icon btn-sm btn-success mark-paid-btn"
                                                        data-invoice-id="{{ $invoice->id }}"
                                                        title="{{ __('messages.btn_mark_paid') }}">
                                                    <i class="ri-check-line"></i>
                                                </button>
                                            @else
                                                <button
                                                    class="btn btn-icon btn-sm btn-teal-gradient btn-wave mark-unpaid-btn"
                                                    data-invoice-id="{{ $invoice->id }}"
                                                    title="{{ __('messages.btn_mark_unpaid') }}">
                                                    <i class="ri-refresh-line"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        {{ __('messages.no_payments_found') }}
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">{{ __('messages.weekly_stats') }}</div>
                </div>
                <div class="card-body">
                    <div id="driverColStats"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('build/assets/libs/apexcharts/apexcharts.js') }}"></script>
    {{-- <script src="{{ asset('build/assets/apexcharts-line-DekI3owz.js') }}"></script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ssnToggle = document.querySelector('.ssn-toggle-icon');
            const ssnValue = document.querySelector('.ssn-value');

            ssnToggle.addEventListener('click', function () {
                const isHidden = ssnValue.textContent === '**********';
                ssnValue.textContent = isHidden ? ssnValue.getAttribute('data-ssn') : '**********';
                this.classList.toggle('bi-eye');
                this.classList.toggle('bi-eye-slash');
            });
        });

    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const data = @json($allInvoices);
            console.log('Chart data from view:', data);

            if (Array.isArray(data) && data.length > 0) {
                // Filter only valid rows with numeric data
                const cleanData = data.filter(inv =>
                    inv &&
                    inv.week_number !== null &&
                    inv.invoice_total !== null &&
                    inv.amount_to_pay_driver !== null
                );

                const weekNumbers = cleanData.map(inv => `W${inv.week_number}`);
                const totalInvoices = cleanData.map(inv => Number(inv.invoice_total) || 0);
                const benefits = cleanData.map(inv => Number(inv.amount_to_pay_driver) || 0);

                console.log('Processed data:', {
                    weekNumbers,
                    totalInvoices,
                    benefits
                });

                // Prevent chart from rendering if all values are zero or empty
                if (weekNumbers.length === 0 || totalInvoices.every(v => v === 0 && benefits.every(b => b === 0))) {
                    console.warn('No valid data to render ApexCharts');
                    document.querySelector("#driverColStats").innerHTML =
                        '<div class="text-center text-muted py-5">{{ __('messages.no_valid_data_for_chart') }}</div>';
                    return;
                }

                const options = {
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: {
                            show: true
                        }
                    },
                    series: [{
                        name: 'Total Invoice',
                        data: totalInvoices,
                        color: '#667eea'
                    },
                        {
                            name: 'Driver Benefit',
                            data: benefits,
                            color: '#10b981'
                        }
                    ],
                    xaxis: {
                        categories: weekNumbers,
                        title: {
                            text: 'Week Number'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Amount ($)'
                        },
                        min: 0
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: val => `$${val.toFixed(2)}`
                    },
                    tooltip: {
                        y: {
                            formatter: val => `$${val.toFixed(2)}`
                        }
                    },
                    legend: {
                        position: 'top'
                    }
                };

                try {
                    const chart = new ApexCharts(document.querySelector("#driverColStats"), options);
                    chart.render();
                    console.log('Chart rendered successfully');
                } catch (error) {
                    console.error('ApexCharts rendering failed:', error);
                }
            } else {
                console.warn('No invoice data available for chart');
            }
        });
    </script>
@endsection
