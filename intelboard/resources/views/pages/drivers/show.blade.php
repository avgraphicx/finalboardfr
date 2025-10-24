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
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.driver') }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('messages.dashboard_menu') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.driver') }}</li>
            </ol>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-xl-3">
            <div class="card custom-card dashboard-main-card primary">
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
                    <h6 class="fw-semibold mt-3 mb-1">{{ $driver->driver_id }} - {{ $driver->full_name }}
                        <span class="p-1">
                            <a href="#" id="editDriverBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#ffffff"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M227.31,73.37,182.63,28.68a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H92.69A15.86,15.86,0,0,0,104,219.31L227.31,96a16,16,0,0,0,0-22.63ZM92.69,208H48V163.31l88-88L180.69,120ZM192,108.68,147.31,64l24-24L216,84.68Z">
                                    </path>
                                </svg>
                            </a>
                        </span>
                    </h6>

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
                                {{ $driver->createdBy?->full_name ?? 'N/A' }} - {{ $driver->created_at->toDateString() }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-9" id="latestPays">
            <div class="card custom-card dashboard-main-card success">
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
                                    <th>{{ __('messages.table_days_worked') }}</th>
                                    <th>{{ __('messages.table_benefit') }}</th>
                                    <th>{{ __('messages.table_final_amount') }}</th>
                                    <th>{{ __('messages.table_actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($driver->invoices()->orderBy('id', 'asc')->limit(10)->get() as $invoice)
                                    <tr id="invoice-row-{{ $invoice->id }}">
                                        <td>
                                            <input type="checkbox" class="form-check-input invoice-checkbox"
                                                data-invoice-id="{{ $invoice->id }}">
                                        </td>
                                        <td>
                                            <span class="badge {{ $invoice->is_paid ? 'bg-success' : 'bg-danger' }}">
                                                {{ __('messages.table_week_short') }}{{ $invoice->week_number }}
                                            </span>
                                        </td>
                                        <td>${{ number_format($invoice->invoice_total, 2) }}</td>
                                        <td>{{ $invoice->total_parcels }}</td>
                                        <td>{{ $invoice->days_worked }}</td>
                                        <td>${{ number_format(($invoice->driver_percentage / 100) * $invoice->invoice_total, 2) }}
                                        </td>
                                        <td class="fw-bold text-success">
                                            ${{ number_format($invoice->amount_to_pay_driver, 2) }}</td>
                                        <td>
                                            <div class="hstack gap-2 fs-15">
                                                <a href="{{ route('invoices.show', $invoice->id) }}"
                                                    class="btn btn-icon btn-sm btn-primary"
                                                    title="{{ __('messages.btn_view') }}">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                                <a href="{{ route('invoices.edit', $invoice->id) }}"
                                                    class="btn btn-icon btn-sm btn-warning"
                                                    title="{{ __('messages.btn_edit') }}">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <button class="btn btn-icon btn-sm btn-danger delete-invoice-btn"
                                                    data-invoice-id="{{ $invoice->id }}"
                                                    title="{{ __('messages.btn_delete') }}">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>

                                                @if (!$invoice->is_paid)
                                                    <button class="btn btn-icon btn-sm btn-success mark-paid-btn"
                                                        data-invoice-id="{{ $invoice->id }}"
                                                        title="{{ __('messages.btn_mark_paid') }}">
                                                        <i class="ri-check-line"></i>
                                                    </button>
                                                @else
                                                    <button
                                                        class="btn btn-icon btn-sm btn-teal-gradient btn-wave mark-unpaid-btn"
                                                        data-invoice-id="{{ $invoice->id }}"
                                                        title="{{ __('messages.btn_mark_unpaid') }}">
                                                        <i class="ri-refresh-line"></i>
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
            const invoiceCheckboxes = document.querySelectorAll('.invoice-checkbox');
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
                const selected = Array.from(invoiceCheckboxes).filter(cb => cb.checked);
                if (selected.length > 0) {
                    selectedCountSpan.textContent = selected.length;
                    bulkButton.style.display = 'inline-block';
                } else {
                    bulkButton.style.display = 'none';
                }
            }

            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                invoiceCheckboxes.forEach(cb => cb.checked = isChecked);
                updateBulkButton();
            });

            invoiceCheckboxes.forEach(cb => cb.addEventListener('change', updateBulkButton));

            // === INDIVIDUAL DELETE ===
            document.querySelectorAll('.delete-invoice-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const invoiceId = this.dataset.invoiceId;

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
                            fetch(`{{ url('invoices') }}/${invoiceId}`, {
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
                                    'An error occurred while deleting the invoice',
                                    'error'));
                        }
                    });
                });
            });

            // === INDIVIDUAL MARK AS PAID ===
            document.querySelectorAll('.mark-paid-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const invoiceId = this.dataset.invoiceId;

                    fetch(`{{ url('invoices') }}/${invoiceId}/mark-paid`, {
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

            // === INDIVIDUAL MARK AS UNPAID ===
            document.querySelectorAll('.mark-unpaid-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const invoiceId = this.dataset.invoiceId;

                    fetch(`{{ url('invoices') }}/${invoiceId}/mark-unpaid`, {
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
                            'Error marking as unpaid', 'error'));
                });

                // === BULK MARK AS PAID ===
                bulkButton.addEventListener('click', function() {
                    const selectedIds = Array.from(invoiceCheckboxes)
                        .filter(cb => cb.checked)
                        .map(cb => cb.dataset.invoiceId);

                    if (selectedIds.length === 0) return;

                    Swal.fire({
                        title: '{{ __('messages.confirm') }}?',
                        text: `Mark ${selectedIds.length} invoices as paid?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: '{{ __('messages.mark_as_paid') }}',
                        cancelButtonText: '{{ __('messages.cancel') }}',
                        confirmButtonColor: '#198754',
                        cancelButtonColor: '#6c757d'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch('{{ route('invoices.mark-paid-bulk') }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').content,
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        invoice_ids: selectedIds
                                    })
                                })
                                .then(r => r.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire('{{ __('messages.success') }}!', data
                                            .message,
                                            'success').then(() => location.reload());
                                    } else {
                                        Swal.fire('{{ __('messages.not_available') }}',
                                            data
                                            .message ||
                                            '{{ __('messages.error_marking_invoices_paid') }}',
                                            'error');
                                    }
                                })
                                .catch(() => Swal.fire(
                                    '{{ __('messages.not_available') }}',
                                    '{{ __('messages.error_bulk_request') }}', 'error'
                                ));
                        }
                    });
                });

                // === EDIT DRIVER INLINE ===
                document.getElementById('editDriverBtn').addEventListener('click', function(e) {
                    e.preventDefault();
                    const driverData = @json($driver);
                    const updateUrl = '{{ route('drivers.update', $driver->id) }}';
                    const container = document.querySelector('.card-body.text-center');
                    container.classList.remove('text-center');
                    container.innerHTML = `
        <form id="editDriverForm" action="${updateUrl}" method="POST" class="p-4">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="PUT">

            <!-- Active Status Checkbox -->
            <div class="form-check mb-3">
                <input type="hidden" name="active" value="0">
                <input type="checkbox" id="driverActiveToggle" name="active" value="1"
                class="form-check-input form-checked-success" ${driverData.active ? 'checked' : ''}>
                <label class="form-check-label ms-2" for="driverActiveToggle">
                    ${driverData.active ? "{{ __('messages.active') }}" : "{{ __('messages.inactive') }}"}
                </label>
            </div>

    <div class="mb-3"><label>Full Name</label><input type="text" name="full_name" class="form-control"
            value="${driverData.full_name}">
    </div>
    <div class="mb-3"><label>Driver ID</label><input type="text" name="driver_id" class="form-control"
            value="${driverData.driver_id}" maxlength="5">
        <div id="inputHelp" class="form-text">Format : X1111</div>
    </div>
    <div class="mb-3"><label>Phone Number</label><input type="text" name="phone_number" class="form-control"
            value="${driverData.phone_number}" pattern="\\d{10}" minlength="10" maxlength="10">
        <div id="inputHelp" class="form-text">Format : 1234567890</div>
    </div>
    <div class="mb-3"><label>License Number</label><input type="text" name="license_number" class="form-control"
            value="${driverData.license_number}">
    </div>
    <div class="mb-3"><label>SSN</label><input type="text" name="ssn" class="form-control"
            value="${driverData.ssn}" pattern="\\d{9}" minlength="9" maxlength="9">
        <div id="inputHelp" class="form-text">Format : 123456789</div>
    </div>
    <div class="mb-3"><label>Default Percentage</label><input type="number" name="default_percentage"
            class="form-control" value="${driverData.default_percentage}" min="1" max="999">
    </div>
    <div class="mb-3"><label>Default Rental Price</label><input type="number" name="default_rental_price"
            class="form-control" value="${driverData.default_rental_price}" min="1" max="999">
    </div>            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
                `;


                    // Attach AJAX submit handler
                    const editForm = document.getElementById('editDriverForm');
                    editForm.addEventListener('submit', function(ev) {
                        ev.preventDefault();
                        const formData = new FormData(editForm);
                        fetch(editForm.action, {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Success', data.message, 'success').then(
                                        () => location.reload());
                                } else {
                                    Swal.fire('Error', data.message || 'Update failed',
                                        'error');
                                }
                            })
                            .catch(() => Swal.fire('Error', 'Unexpected error occurred',
                                'error'));
                    });
                });
            });

        });
        {{-- close DOMContentLoaded listener --}}
    </script>
@endsection
