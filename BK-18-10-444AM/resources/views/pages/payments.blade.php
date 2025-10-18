@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">Payments</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Payments</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="card-title">Payments List</div>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#uploadPaymentModal">
                            <i class="ri-add-line"></i> Add Payment
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover" id="payments-table">
                            <thead>
                                <tr>
                                    <th>Driver</th>
                                    <th>Week #</th>
                                    <th>Total Invoice</th>
                                    <th>Parcels</th>
                                    <th>Rental Price</th>
                                    <th>Broker %</th>
                                    <th>Bonus</th>
                                    <th>Cash Advance</th>
                                    <th>Final Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->driver->full_name ?? 'N/A' }}</td>
                                        <td>{{ $payment->week_number }}</td>
                                        <td>${{ number_format($payment->total_invoice, 2) }}</td>
                                        <td>{{ $payment->parcel_rows_count }}</td>
                                        <td>${{ number_format($payment->vehicule_rental_price ?? 0, 2) }}</td>
                                        <td>{{ $payment->broker_percentage ?? 0 }}%</td>
                                        <td>${{ number_format($payment->bonus, 2) }}</td>
                                        <td>${{ number_format($payment->cash_advance, 2) }}</td>
                                        <td class="fw-bold">${{ number_format($payment->final_amount, 2) }}</td>
                                        <td>
                                            <div class="hstack gap-2 fs-15">
                                                <a href="{{ route('payments.show', $payment->id) }}"
                                                    class="btn btn-icon btn-sm btn-primary" title="View">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('payments.edit', $payment->id) }}"
                                                    class="btn btn-icon btn-sm btn-warning" title="Edit">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <a href="javascript:void(0);" data-id="{{ $payment->id }}"
                                                    class="btn btn-icon btn-sm btn-danger delete-payment-btn"
                                                    title="Delete">
                                                    <i class="ri-delete-bin-line"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-4">
                                            No payments found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Upload Payment Modal -->
<div class="modal fade" id="uploadPaymentModal" style="display: none;" tabindex="-1"
    aria-labelledby="uploadPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="uploadPaymentModalLabel">Upload Payment</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadPaymentForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="paymentFile" class="form-label">Select File</label>
                        <input type="file" class="form-control" id="paymentFile" name="pdf_path" accept=".pdf"
                            required>
                        <small class="text-muted">Accepted format: PDF</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-upload-cloud-line"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
@endsection
