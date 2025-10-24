@extends('layouts.master')

@section('content')
    <div class="page-header-breadcrumb mb-3">
        <h1 class="page-title">{{ __('messages.view_expense') }}</h1>
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary ms-auto">{{ __('messages.back') }}</a>
    </div>

    <div class="card">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">{{ __('messages.title') }}</dt>
                <dd class="col-sm-9">{{ $expense->title }}</dd>
                <dt class="col-sm-3">{{ __('messages.amount') }}</dt>
                <dd class="col-sm-9">${{ $expense->amount }}</dd>
                <dt class="col-sm-3">{{ __('messages.week') }}</dt>
                <dd class="col-sm-9">{{ $expense->week }}</dd>
                <dt class="col-sm-3">{{ __('messages.for') }}</dt>
                <dd class="col-sm-9">{{ $expense->for }}</dd>
                <dt class="col-sm-3">{{ __('messages.note') }}</dt>
                <dd class="col-sm-9">{{ $expense->note }}</dd>
                <dt class="col-sm-3">{{ __('messages.created_at') }}</dt>
                <dd class="col-sm-9">{{ $expense->created_at }}</dd>
                <dt class="col-sm-3">{{ __('messages.updated_at') }}</dt>
                <dd class="col-sm-9">{{ $expense->updated_at }}</dd>
            </dl>
        </div>
    </div>
@endsection
