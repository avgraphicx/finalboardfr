@extends('layouts.master')

@section('styles')
    {{-- Using modern CDN links that you provided --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0"></h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('messages.dashboard_menu') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.driver') }}</li>
            </ol>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-xl-3">
            <div class="card custom-card">
                <div class="card-body text-center p-4">
                    @php
                        $nameParts = explode(' ', trim($driver->full_name));
                        $initials = '';
                        foreach ($nameParts as $part) {
                            if (!empty($part)) {
                                $initials .= strtoupper(substr($part, 0, 1));
                            }
                        }
                        $initials = substr($initials, 0, 2);
                    @endphp
                    <span class="avatar avatar-xxl avatar-rounded bg-primary text-light">
                        <span class="avatar-text fw-bold fs-5" style="color: white !important;">{{ $initials }}</span>
                        <span id="active"
                            class="badge rounded-pill  @if ($driver->active == 0) bg-danger @endif
                            @if ($driver->active == 1) bg-success @endif avatar-badge"></span>
                    </span>

                    <h6 class="fw-semibold mt-3 mb-1">{{ $driver->driver_id }} - {{ $driver->full_name }}</h6>

                    <ul class="nav nav-tabs flex-column nav-tabs-header mb-0 mail-sesttings-tab" role="tablist">
                        <li class="nav-item m-1 text-success" id="protab">
                            <a href="javascript:void(0)" class="pe-none text-success fw-medium nav-link active"
                                tabindex="-1">
                                <i class="bi bi-phone me-1"></i> {{ $driver->phone_number }}
                            </a>
                        </li>
                        <li class="nav-item m-1" id="protab2">
                            <a href="javascript:void(0)" class="pe-none text-primary fw-medium nav-link" tabindex="-1">
                                <i class="bi bi-person-vcard me-1"></i> {{ $driver->license_number }}
                            </a>
                        </li>
                        <li class="nav-item m-1" id="protab2">
                            <a href="javascript:void(0)"
                                class="text-primary fw-medium nav-link cursor-pointer d-flex align-items-center gap-2">
                                <span class="ssn-value" data-ssn="{{ $driver->ssn }}">**********</span>
                                <i class="bi bi-eye ssn-toggle-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item m-1" id="protab2">
                            <a href="javascript:void(0)" class="pe-none text-primary fw-medium nav-link" tabindex="-1">
                                <i class="bi bi-percent me-1"></i> {{ $driver->default_percentage }}%
                            </a>
                        </li>
                        <li class="nav-item m-1" id="protab2">
                            <a href="javascript:void(0)" class="pe-none text-primary fw-medium nav-link" tabindex="-1">
                                <i class="bi bi-cash-coin me-1"></i> {{ $driver->default_rental_price }}$
                            </a>
                        </li>
                        <li class="nav-item m-1" id="protab2">
                            <a href="javascript:void(0)" class="pe-none text-primary fw-medium nav-link" tabindex="-1">
                                <i class="bi bi-person-circle me-1"></i>
                                {{ $driver->addedBy?->full_name ?? 'N/A' }} - {{ $driver->created_at }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-9" id="latestPays">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">{{ __('messages.driver_payments') }}</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="driver-payments-table">
                            <thead>
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" id="select-all-payments" class="form-check-input">
                                    </th>
                                    <th>{{ __('messages.table_week_number') }}</th>
                                    <th>{{ __('messages.table_total_invoice') }}</th>
                                    <th>{{ __('messages.table_parcel_rows') }}</th>
                                    <th>{{ __('messages.table_benefit') }}</th>
                                    <th>{{ __('messages.table_final_amount') }}</th>
                                    <th>{{ __('messages.table_actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($driver->payments()->orderBy('week_number', 'asc')->limit(10)->get() as $payment)
                                    <tr id="payment-row-{{ $payment->id }}">
                                        <td>
                                            <input type="checkbox" class="form-check-input payment-checkbox"
                                                data-payment-id="{{ $payment->id }}">
                                        </td>
                                        <td>
                                            <span class="badge {{ $payment->paid ? 'bg-success' : 'bg-danger' }}">
                                                {{ $payment->week_number }}
                                            </span>
                                        </td>
                                        <td>${{ number_format($payment->total_invoice, 2) }}</td>
                                        <td>{{ $payment->parcel_rows_count }}</td>
                                        <td>${{ number_format($payment->broker_van_cut + $payment->broker_pay_cut, 2) }}
                                        </td>
                                        <td class="fw-bold text-success">${{ number_format($payment->final_amount, 2) }}
                                        </td>
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
                                                <button class="btn btn-icon btn-sm btn-danger delete-payment-btn"
                                                    data-payment-id="{{ $payment->id }}"
                                                    title="{{ __('messages.btn_delete') }}">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>

                                                @if (!$payment->paid)
                                                    <button class="btn btn-icon btn-sm btn-success mark-paid-btn"
                                                        data-url="{{ route('payments.markPaid', $payment->id) }}"
                                                        data-payment-id="{{ $payment->id }}"
                                                        title="{{ __('messages.btn_mark_paid') }}">
                                                        <i class="ri-check-line"></i>
                                                    </button>
                                                @else
                                                    <button class="btn btn-icon btn-sm btn-secondary" disabled>
                                                        <i class="ri-check-double-line"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            {{ __('messages.no_payments_found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // === SSN TOGGLE ===
            document.querySelectorAll('.ssn-value').forEach(function(element) {
                element.closest('a').addEventListener('click', function(e) {
                    e.preventDefault();
                    const ssnSpan = element;
                    const toggleIcon = this.querySelector('.ssn-toggle-icon');
                    const actualSSN = ssnSpan.dataset.ssn;
                    const isMasked = ssnSpan.textContent.includes('*');
                    ssnSpan.textContent = isMasked ? actualSSN : '**********';
                    toggleIcon.style.opacity = isMasked ? '0.6' : '1';
                });
            });

            const selectAllCheckbox = document.getElementById('select-all-payments');
            const paymentCheckboxes = document.querySelectorAll('.payment-checkbox');
            const bulkActionContainer = document.createElement('div');
            bulkActionContainer.innerHTML = `
        <button id="bulk-mark-paid" class="btn btn-success mt-3 form-control" style="display:none;">
            Mark <span id="selected-count">0</span> as paid <i class="bi bi-check-all"></i>
        </button>
    `;
            document.querySelector('#latestPays .card-body').prepend(bulkActionContainer);

            const bulkButton = document.getElementById('bulk-mark-paid');
            const selectedCountSpan = document.getElementById('selected-count');

            function updateBulkButton() {
                const selected = Array.from(paymentCheckboxes).filter(cb => cb.checked);
                if (selected.length > 0) {
                    selectedCountSpan.textContent = selected.length;
                    bulkButton.style.display = 'inline-block';
                } else {
                    bulkButton.style.display = 'none';
                }
            }

            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                paymentCheckboxes.forEach(cb => cb.checked = isChecked);
                updateBulkButton();
            });

            paymentCheckboxes.forEach(cb => cb.addEventListener('change', updateBulkButton));

            // === INDIVIDUAL DELETE ===
            document.querySelectorAll('.delete-payment-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const paymentId = this.dataset.paymentId;

                    Swal.fire({
                        title: '{{ __('messages.confirm') }}?',
                        text: '{{ __('messages.confirm_delete_driver') }}',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: '{{ __('messages.delete') }}',
                        cancelButtonText: '{{ __('messages.cancel') }}',
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`{{ url('payments') }}/${paymentId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').content,
                                        'X-Requested-With': 'XMLHttpRequest'
                                    }
                                })
                                .then(r => r.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire('{{ __('messages.success') }}!', data
                                            .message, 'success').then(() => location
                                            .reload());
                                    } else {
                                        Swal.fire('{{ __('messages.not_available') }}',
                                            data.message, 'error');
                                    }
                                })
                                .catch(() => Swal.fire(
                                    '{{ __('messages.not_available') }}',
                                    'An error occurred while deleting the payment',
                                    'error'));
                        }
                    });
                });
            });

            // === INDIVIDUAL MARK AS PAID ===
            document.querySelectorAll('.mark-paid-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const paymentId = this.dataset.paymentId;

                    fetch(`{{ url('payments') }}/${paymentId}/mark-paid`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('{{ __('messages.success') }}!', data.message,
                                    'success').then(() => location.reload());
                            } else {
                                Swal.fire('{{ __('messages.not_available') }}', data.message ||
                                    'Error', 'error');
                            }
                        })
                        .catch(() => Swal.fire('{{ __('messages.not_available') }}',
                            'Error marking as paid', 'error'));
                });
            });

            // === BULK MARK AS PAID ===
            bulkButton.addEventListener('click', function() {
                const selectedIds = Array.from(paymentCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.dataset.paymentId);

                if (selectedIds.length === 0) return;

                Swal.fire({
                    title: '{{ __('messages.confirm') }}?',
                    text: `Mark ${selectedIds.length} payments as paid?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: '{{ __('messages.mark_as_paid') }}',
                    cancelButtonText: '{{ __('messages.cancel') }}',
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('{{ route('payments.markPaidBulk') }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    payment_ids: selectedIds
                                })
                            })
                            .then(r => r.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('{{ __('messages.success') }}!', data.message,
                                        'success').then(() => location.reload());
                                } else {
                                    Swal.fire('{{ __('messages.not_available') }}', data
                                        .message ||
                                        '{{ __('messages.error_marking_payments_paid') }}',
                                        'error');
                                }
                            })
                            .catch(() => Swal.fire('{{ __('messages.not_available') }}',
                                '{{ __('messages.error_bulk_request') }}', 'error'));
                    }
                });
            });
        });
    </script>
@endsection
