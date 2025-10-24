@extends('layouts.master')

@section('content')
    <!-- Start::page-header -->
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.invoices') ?? 'Invoices' }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.invoices') ?? 'Invoices' }}</li>
            </ol>
        </div>
    </div>
    <!-- End::page-header -->

    <div class="row">
        <div class="col-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">{{ __('messages.invoices_list') ?? 'Invoices List' }}</div>
                    <a href="{{ route('invoices.create') }}" class="btn btn-sm btn-primary">
                        <i class="ri-add-line me-2"></i>{{ __('messages.create_invoice') ?? 'Create Invoice' }}
                    </a>
                </div>
                <div class="card-body">
                    @if ($invoices->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.id') ?? 'ID' }}</th>
                                        <th>{{ __('messages.driver') ?? 'Driver' }}</th>
                                        <th>{{ __('messages.week') ?? 'Week' }}</th>
                                        <th>{{ __('messages.warehouse') ?? 'Warehouse' }}</th>
                                        <th>{{ __('messages.parcels') ?? 'Parcels' }}</th>
                                        <th>{{ __('messages.total') ?? 'Total' }}</th>
                                        <th>{{ __('messages.status') ?? 'Status' }}</th>
                                        <th>{{ __('messages.actions') ?? 'Actions' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                        <tr>
                                            <td>#{{ $invoice->id }}</td>
                                            <td>{{ $invoice->driver->full_name ?? 'N/A' }}</td>
                                            <td>{{ $invoice->week_number }}</td>
                                            <td>{{ $invoice->warehouse_name }}</td>
                                            <td>{{ $invoice->total_parcels }}</td>
                                            <td>${{ number_format($invoice->invoice_total, 2) }}</td>
                                            <td>
                                                @if ($invoice->is_paid)
                                                    <span
                                                        class="badge bg-success">{{ __('messages.paid') ?? 'Paid' }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-warning">{{ __('messages.unpaid') ?? 'Unpaid' }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('invoices.show', $invoice) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('invoices.edit', $invoice) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <form action="{{ route('invoices.destroy', $invoice) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('{{ __('messages.confirm_delete') ?? 'Are you sure?' }}')">
                                                        <i class="ri-delete-line"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $invoices->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            {{ __('messages.no_invoices') ?? 'No invoices found.' }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
