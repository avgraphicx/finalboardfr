@extends('layouts.master')

@section('content')
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.average_metrics') ?? 'Average Metrics' }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    @if (isset($stats))
                        <h5>{{ __('messages.statistics') ?? 'Statistics' }}</h5>
                        <table class="table">
                            <tr>
                                <td>{{ __('messages.average_invoice_amount') ?? 'Average Invoice Amount' }}</td>
                                <td>${{ number_format($stats['avg_invoice'] ?? 0, 2) }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('messages.average_parcels') ?? 'Average Parcels' }}</td>
                                <td>{{ $stats['avg_parcels'] ?? 0 }}</td>
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
