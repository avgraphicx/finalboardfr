@extends('layouts.master')

@section('styles')
@endsection

@section('content')
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.payments_page_label') }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('messages.dashboard') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.payments_page_label') }}</li>
            </ol>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row mb-4">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="card-title mb-0">{{ __('messages.upload_invoices') }}</div>
                    <a class="btn btn-primary" href="{{ route('payments.importForm') }}">
                        <i class="ri-upload-2-line"></i> {{ __('messages.upload_invoices') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Existing payments list (simple) -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="card-title">{{ __('messages.payments_page_label') }}</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('messages.driver') }}</th>
                                    <th>{{ __('messages.week') }}</th>
                                    <th>{{ __('messages.total_invoice') }}</th>
                                    <th>{{ __('messages.final_amount') }}</th>
                                    <th>{{ __('messages.status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->id }}</td>
                                        <td>{{ $payment->driver?->full_name }} ({{ $payment->driver?->driver_id }})</td>
                                        <td>{{ $payment->week_number }}</td>
                                        <td>{{ number_format($payment->total_invoice, 2) }}</td>
                                        <td>{{ number_format($payment->final_amount, 2) }}</td>
                                        <td>
                                            @if ($payment->paid)
                                                <span class="badge bg-success">{{ __('messages.paid') }}</span>
                                            @else
                                                <span class="badge bg-warning">{{ __('messages.unpaid') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">{{ __('messages.no_data') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function showCompletionScreen() {
            document.getElementById('progressDiv').style.display = 'none';
            document.getElementById('completeDiv').style.display = 'block';

            let content = `<div class="mb-4">`;

            // Check existing payments
            // Reset existing and insert lists
            driversExists = [];
            driversToInsert = [];
            // Detect duplicate invoices in this upload batch (consider driver, week and warehouse)
            let seenBatch = {};
            let batchDuplicates = [];
            let uniqueBatch = [];
            driversFound.forEach(driver => {
                // include warehouse in dedupe key (empty string if missing)
                const wh = driver.warehouse ?? '';
                const key = `${driver.driver_id}_${driver.week_number}_${wh}`;
                if (seenBatch[key]) {
                    batchDuplicates.push(driver);
                } else {
                    seenBatch[key] = true;
                    uniqueBatch.push(driver);
                }
            });
        }
    </script>
@endsection

@section('scripts')
@endsection
