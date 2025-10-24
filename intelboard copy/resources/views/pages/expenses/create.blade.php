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
                    <label class="form-label">{{ __('messages.title') }}</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.amount') }}</label>
                    <input type="number" step="0.01" name="amount" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.day') }}</label>
                    <input type="date" name="day" class="form-control" required>
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
