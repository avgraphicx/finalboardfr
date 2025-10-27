@extends('layouts.master')

@section('content')
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.dashboard') ?? 'Dashboard' }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    <h5>{{ __('messages.weekly_statistics') ?? 'Weekly Statistics' }}</h5>
                    @if (isset($stats))
                        <table class="table">
                            <tr>
                                <td>{{ __('messages.total_invoices') ?? 'Total Invoices' }}</td>
                                <td>{{ $stats['total_invoices'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('messages.total_amount') ?? 'Total Amount' }}</td>
                                <td>${{ number_format($stats['total_amount'] ?? 0, 2) }}</td>
                            </tr>
                        </table>
                    @else
                        <div class="alert alert-info">{{ __('messages.no_data_available') ?? 'No data available.' }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
