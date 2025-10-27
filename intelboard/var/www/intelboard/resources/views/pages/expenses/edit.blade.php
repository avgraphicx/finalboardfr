@extends('layouts.master')

@section('content')
    <div class="page-header-breadcrumb mb-3">
        <h1 class="page-title">{{ __('messages.edit_expense') }}</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('expenses.update', $expense) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.title') }}</label>
                    <input type="text" name="title" value="{{ $expense->title }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.amount') }}</label>
                    <input type="number" step="0.01" name="amount" value="{{ $expense->amount }}" class="form-control"
                        required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.week') }}</label>
                    <input type="number" name="week" value="{{ $expense->week }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.for') }}</label>
                    <input type="text" name="for" value="{{ $expense->for }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('messages.note') }}</label>
                    <textarea name="note" class="form-control">{{ $expense->note }}</textarea>
                </div>
                <button class="btn btn-primary">{{ __('messages.update') }}</button>
            </form>
        </div>
    </div>
@endsection
