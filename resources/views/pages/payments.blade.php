@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="card-title">{{ __('messages.payments_list') }}</div>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#uploadPaymentModal">
                            <i class="ri-add-line"></i> {{ __('messages.add_payment') }}
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover" id="payments-table">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.table_driver') }}</th>
                                    <th>{{ __('messages.table_week') }}</th>
                                    <th>{{ __('messages.table_total_invoice') }}</th>
                                    <th>{{ __('messages.table_parcels') }}</th>
                                    <th>{{ __('messages.table_rental_price') }}</th>
                                    <th>{{ __('messages.table_broker_percent') }}</th>
                                    <th>{{ __('messages.table_bonus') }}</th>
                                    <th>{{ __('messages.table_cash_advance') }}</th>
                                    <th>{{ __('messages.table_final_amount') }}</th>
                                    <th>{{ __('messages.table_actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->driver->full_name ?? __('messages.not_available_short') }}</td>
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
                                                    class="btn btn-icon btn-sm btn-primary"
                                                    title="{{ __('messages.btn_view') }}">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('payments.edit', $payment->id) }}"
                                                    class="btn btn-icon btn-sm btn-warning"
                                                    title="{{ __('messages.btn_edit') }}">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <a href="javascript:void(0);" data-id="{{ $payment->id }}"
                                                    class="btn btn-icon btn-sm btn-danger delete-payment-btn"
                                                    title="{{ __('messages.btn_delete') }}">
                                                    <i class="ri-delete-bin-line"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-4">
                                            {{ __('messages.no_payments_found') }}
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
                <h1 class="modal-title fs-5" id="uploadPaymentModalLabel">{{ __('messages.payment_upload_title') }}
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="uploadPaymentForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="paymentFile" class="form-label">{{ __('messages.select_file_label') }}</label>
                        <input type="file" class="form-control" id="paymentFile" name="pdf_path" accept=".pdf"
                            required>
                        <small class="text-muted">{{ __('messages.pdf_format_text') }}</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary form-control">
                        <i class="ri-upload-cloud-line"></i> {{ __('messages.upload') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        document.getElementById('uploadPaymentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('{{ route('payments.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: '{{ __('messages.success') }}!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: '{{ __('messages.confirm') }}'
                        }).then(() => {
                            document.getElementById('uploadPaymentForm').reset();
                            const modal = bootstrap.Modal.getInstance(document.getElementById(
                                'uploadPaymentModal'));
                            modal.hide();
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: '{{ __('messages.not_available') }}',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: '{{ __('messages.confirm') }}'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: '{{ __('messages.not_available') }}',
                        text: '{{ __('messages.error_processing_response') }}',
                        icon: 'error',
                        confirmButtonText: '{{ __('messages.confirm') }}'
                    });
                });
        });
    </script>
@endsection
