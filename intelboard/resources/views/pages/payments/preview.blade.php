@extends('layouts.master')

@section('styles')
@endsection

@section('content')
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.preview') }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a
                        href="{{ route('invoices.index') }}">{{ __('messages.payments_page_label') }}</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('payments.importForm') }}">{{ __('messages.upload_invoices') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.preview') }}</li>
            </ol>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $importables = collect($items)->filter(fn($i) => ($i['status'] ?? '') === 'ok')->values();
        $duplicatesDb = collect($items)->filter(fn($i) => ($i['status'] ?? '') === 'duplicate_in_db')->values();
        $duplicatesBatch = collect($items)->filter(fn($i) => ($i['status'] ?? '') === 'duplicate_in_batch')->values();
        $missingDrivers = collect($items)->filter(fn($i) => ($i['status'] ?? '') === 'missing_driver')->values();
        $parseErrors = collect($items)->filter(fn($i) => ($i['status'] ?? '') === 'parse_error')->values();
    @endphp

    <div class="row">
        <div class="col-xl-12">

            @if ($duplicatesBatch->count() > 0)
                <div class="alert alert-warning">
                    <strong><i class="bi bi-info-circle-fill"></i> {{ $duplicatesBatch->count() }} duplicate(s) in this
                        upload batch:</strong>
                    <ul class="mb-0">
                        @foreach ($duplicatesBatch as $i)
                            <li>{{ $i['file_name'] }} — {{ $i['driver_id'] ?? '' }} {{ $i['driver_full_name'] ?? '' }}
                                ({{ $i['week_number'] ?? '' }})
                                [{{ $i['warehouse'] ?? 'N/A' }}]</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($duplicatesDb->count() > 0)
                <div class="alert alert-danger">
                    <strong><i class="bi bi-info-circle-fill"></i> {{ $duplicatesDb->count() }}
                        {{ __('messages.pay_exists_for_driver') }}:</strong>
                    <ul class="mb-0">
                        @foreach ($duplicatesDb as $i)
                            <li>{{ $i['file_name'] }} — {{ $i['driver_id'] ?? '' }} {{ $i['driver_full_name'] ?? '' }}
                                ({{ $i['week_number'] ?? '' }})
                                [{{ $i['warehouse'] ?? 'N/A' }}]</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($missingDrivers->count() > 0)
                <div class="alert alert-danger">
                    <strong><i class="bi bi-exclamation-circle-fill"></i> {{ $missingDrivers->count() }}
                        {{ __('messages.drivers_not_found') }}:</strong>
                    <ul class="mb-0">
                        @foreach ($missingDrivers as $i)
                            <li>{{ $i['file_name'] }} — {{ $i['driver_id'] ?? '' }} ({{ $i['week_number'] ?? '' }})
                                [{{ $i['warehouse'] ?? 'N/A' }}]</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($parseErrors->count() > 0)
                <div class="alert alert-secondary">
                    <strong>{{ $parseErrors->count() }} file(s) could not be parsed:</strong>
                    <ul class="mb-0">
                        @foreach ($parseErrors as $i)
                            <li>{{ $i['file_name'] }} — {{ $i['status_reason'] ?? '' }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="card-title">
                        {{ __('messages.drivers_found') }}: {{ $importables->count() }}
                    </div>
                </div>
                <div class="card-body">
                    @if ($importables->count() === 0)
                        <p class="text-muted mb-0">{{ __('messages.no_data_to_save') }}</p>
                    @else
                        <form method="POST" action="{{ route('payments.importBatch') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="list-group mb-3">
                                @foreach ($importables as $i)
                                    <label class="list-group-item d-flex align-items-start gap-3">
                                        <input type="checkbox" class="form-check-input mt-1" name="selected[]"
                                            value="{{ $i['key'] }}" checked>
                                        <div class="d-flex flex-column">
                                            <strong>{{ $i['driver_id'] }} — {{ $i['driver_full_name'] }}</strong>
                                            <small class="text-muted">{{ __('messages.week') }}: {{ $i['week_number'] }} •
                                                {{ __('messages.file') }}: {{ $i['file_name'] }}</small>
                                            <small class="text-muted">Warehouse: {{ $i['warehouse'] ?? 'N/A' }}</small>
                                            <small class="text-muted">{{ __('messages.total_invoice') }}:
                                                {{ number_format($i['total_invoice'] ?? 0, 2) }} •
                                                {{ __('messages.total_parcels') }}: {{ $i['total_parcels'] ?? 0 }} •
                                                {{ __('messages.final_amount') }}:
                                                {{ number_format($i['final_amount'] ?? 0, 2) }}</small>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            <div class="d-flex gap-2 mt-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="ri-check-line"></i>
                                    {{ __('messages.proceed_with_count', ['count' => $importables->count()]) }}
                                </button>
                                <a href="{{ route('payments.importForm') }}" class="btn btn-teal-light">
                                    <i class="bi bi-arrow-left-circle-fill"></i> {{ __('messages.cancel') }}
                                </a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
@endsection
