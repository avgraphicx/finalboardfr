@extends('layouts.master')

@section('content')
    <div class="page-header-breadcrumb mb-3">
        <h1 class="page-title">{{ __('messages.add_expense') }}</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.date') }}</label>
                    <div class="input-group">
                        <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                        <input type="text" class="form-control flatpickr-input" name="date" id="date"
                            placeholder="{{ __('messages.pick_date') }}" readonly="readonly">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('messages.amount') }}</label>
                    <input type="number" step="0.01" name="amount" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('messages.for') }}</label>
                    <input type="text" name="for" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.note') }}</label>
                    <textarea name="note" class="form-control"></textarea>
                </div>
                <button class="btn btn-primary">{{ __('messages.save') }}</button>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('build/assets/date_time_pickers-CCal6qif.js') }}"></script>
@endsection
