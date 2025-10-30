@extends('layouts.master')
@section('styles')
    {{-- Using modern CDN links that you provided --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notie/4.3.1/notie.min.css">
@endsection
@section('content')
    <!-- Start::page-header -->
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.add_expense') }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('expenses.index') }}">{{ __('messages.expenses') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.add_new') }}</li>
            </ol>
        </div>
    </div>
    <!-- End::page-header -->
    {{-- <div class="page-header-breadcrumb mb-3">
        <h1 class="page-title">{{ __('messages.expenses') }}</h1>
        <a href="{{ route('expenses.create') }}" class="btn btn-primary ms-auto">{{ __('messages.add_expense') }}</a>
    </div> --}}

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="card-title">
                <a href="{{ route('expenses.create') }}" id="createExpenseBtn" class="btn btn-sm btn-primary mt-2">
                    <i class="ri-add-line me-2"></i>{{ __('messages.add_expense') }}
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="d-none d-md-table-cell">{{ __('messages.week') }}</th>
                            <th>{{ __('messages.date') }}</th>
                            <th>{{ __('messages.amount') }}</th>

                            <th class="d-none d-md-table-cell">{{ __('messages.for') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expenses as $expense)
                            <tr>
                                <td class="d-none d-md-table-cell">{{ $expense->week }}</td>
                                <td>
                                    @php $rawDate = $expense->date; @endphp
                                    <span class="d-none d-md-inline">{{ $rawDate }}</span>
                                    <span
                                        class="d-md-none">{{ $rawDate ? \Carbon\Carbon::parse($rawDate)->format('y/m/d') : '' }}</span>
                                </td>
                                <td>{{ $expense->amount }}</td>

                                <td class="d-none d-md-table-cell">{{ $expense->for }}</td>
                                <td>
                                    <a href="{{ route('expenses.show', $expense) }}" class="btn btn-sm btn-info"><i
                                            class="ri-eye-line"></i></a>
                                    <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-sm btn-warning"><i
                                            class="ri-edit-line"></i></a>
                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('{{ __('messages.confirm_delete') }}')"><i
                                                class="ri-delete-bin-2-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $expenses->links() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notie/4.3.1/notie.min.js"></script>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                notie.setOptions({
                    transitionCurve: 'cubic-bezier(0.68, -0.55, 0.27, 1.55)', // bounce
                    animationDelay: 350,
                    alertTime: 4
                });

                notie.alert({
                    type: 1,
                    text: "{{ session('success') }}",
                    stay: false,
                    time: 3,
                    position: 'top'
                });
            });
        </script>
    @endif
@endsection
