@extends('layouts.master')

@section('content')
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.earnings_by_week') ?? 'Earnings by Week' }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    @if (isset($weeks) && $weeks->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.week') ?? 'Week' }}</th>
                                        <th>{{ __('messages.earnings') ?? 'Earnings' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($weeks as $week)
                                        <tr>
                                            <td>{{ $week->week_number ?? 'N/A' }}</td>
                                            <td>${{ number_format($week->earnings ?? 0, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">{{ __('messages.no_data_available') ?? 'No data available.' }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
