@extends('layouts.master')

@section('content')
    <div class="page-header-breadcrumb mb-3">
        <h1 class="page-title">{{ __('messages.expenses') }}</h1>
        <a href="{{ route('expenses.create') }}" class="btn btn-primary ms-auto">{{ __('messages.add_expense') }}</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('messages.title') }}</th>
                        <th>{{ __('messages.amount') }}</th>
                        <th>{{ __('messages.week') }}</th>
                        <th>{{ __('messages.for') }}</th>
                        <th>{{ __('messages.note') }}</th>
                        <th>{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expenses as $expense)
                        <tr>
                            <td>{{ $expense->title }}</td>
                            <td>{{ $expense->amount }}</td>
                            <td>{{ $expense->week }}</td>
                            <td>{{ $expense->for }}</td>
                            <td>{{ Str::limit($expense->note, 50) }}</td>
                            <td>
                                <a href="{{ route('expenses.show', $expense) }}"
                                    class="btn btn-sm btn-info">{{ __('messages.view') }}</a>
                                <a href="{{ route('expenses.edit', $expense) }}"
                                    class="btn btn-sm btn-warning">{{ __('messages.edit') }}</a>
                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('{{ __('messages.confirm_delete') }}')">{{ __('messages.delete') }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $expenses->links() }}
        </div>
    </div>
@endsection
