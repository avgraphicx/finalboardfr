@extends('layouts.master')

@section('content')
    <!-- Start::page-header -->
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.drivers') ?? 'Drivers' }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('messages.dashboard_menu') }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.drivers') ?? 'Drivers' }}</li>
            </ol>
        </div>
    </div>
    <!-- End::page-header -->

    <div class="row">
        <div class="col-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">{{ __('messages.drivers_list') ?? 'Drivers List' }}</div>
                    <a href="{{ route('drivers.create') }}" class="btn btn-sm btn-primary">
                        <i class="ri-add-line me-2"></i>{{ __('messages.add_driver') ?? 'Add Driver' }}
                    </a>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex gap-2 align-items-center">
                            <div style="flex: 1;">
                                <input type="text" id="searchInput" class="form-control form-control-sm"
                                    placeholder="{{ __('messages.search_by_name_or_driver_id') }}">
                            </div>
                            <button type="button" class="btn btn-sm btn-secondary" id="clearBtn">
                                <i class="ri-close-line"></i>
                            </button>
                            <span class="text-muted fs-13" id="recordCount"></span>
                        </div>
                    </div>

                    <div class="mb-3" id="bulkActionContainer" style="display: none;">
                        <button type="button" class="btn btn-sm btn-danger" id="bulkDeleteBtn">
                            <i class="ri-delete-bin-2-line me-1"></i>Delete <span id="selectedCount">0</span> Driver(s)
                        </button>
                    </div>

                    @if ($drivers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="driversTable">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;">
                                            <input type="checkbox" id="selectAll" class="form-check-input">
                                        </th>
                                        <th class="d-none d-md-table-cell">{{ __('messages.driver_id') ?? 'Driver ID' }}
                                        </th>
                                        <th>{{ __('messages.full_name') ?? 'Full Name' }}</th>
                                        <th class="d-none d-md-table-cell">
                                            {{ __('messages.default_percentage') ?? 'License #' }}</th>
                                        <th class="d-none d-md-table-cell">
                                            {{ __('messages.default_rental_price') ?? 'SSN' }}</th>
                                        <th class="d-none d-md-table-cell">{{ __('messages.status') ?? 'Status' }}</th>
                                        <th>{{ __('messages.actions') ?? 'Actions' }}</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    @foreach ($drivers as $driver)
                                        <tr class="driver-row" data-driver-id="{{ strtolower($driver->driver_id) }}"
                                            data-driver-name="{{ strtolower($driver->full_name) }}">
                                            <td>
                                                <input type="checkbox" class="form-check-input driver-checkbox"
                                                    value="{{ $driver->id }}">
                                            </td>
                                            <td class="d-none d-md-table-cell"><strong>{{ $driver->driver_id }}</strong>
                                            </td>
                                            <td>
                                                <span class="d-none d-md-inline">{{ $driver->full_name }}</span>
                                                <span class="d-md-none">
                                                    @php
                                                        $names = explode(' ', trim($driver->full_name));
                                                        $firstName = $names[0] ?? '';
                                                        $lastName = $names[count($names) - 1] ?? '';
                                                        $initials =
                                                            $firstName .
                                                            '  .' .
                                                            (strlen($lastName) > 0 ? substr($lastName, 0, 1) : '');
                                                    @endphp
                                                    {{ trim($initials) }}
                                                </span>
                                            </td>
                                            <td class="d-none d-md-table-cell">{{ $driver->default_percentage ?? 'N/A' }}%
                                            </td>
                                            <td class="d-none d-md-table-cell">
                                                {{ $driver->default_rental_price ?? 'N/A' }}$</td>
                                            <td class="d-none d-md-table-cell">
                                                @if ($driver->active)
                                                    <span
                                                        class="badge bg-success-transparent">{{ __('messages.active') ?? 'Active' }}</span>
                                                @else
                                                    <span
                                                        class="badge bg-danger-transparent">{{ __('messages.inactive') ?? 'Inactive' }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('drivers.show', $driver) }}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="ri-eye-line"></i>
                                                    </a>
                                                    <a href="{{ route('drivers.edit', $driver) }}"
                                                        class="btn btn-sm btn-warning">
                                                        <i class="ri-edit-line"></i>
                                                    </a>
                                                    <form action="{{ route('drivers.destroy', $driver) }}" method="POST"
                                                        style="display:inline;" class="confirm-delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger confirm-delete-btn"
                                                            data-confirm-message="{{ __('messages.confirm_delete') ?? 'Are you sure?' }}">
                                                            <i class="ri-delete-bin-2-fill"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="noResults" class="alert alert-info d-none">
                            {{ __('messages.no_drivers') ?? 'No drivers found.' }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            {{ __('messages.no_drivers') ?? 'No drivers found. Click above to add your first driver.' }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        #tableBody tr.hidden {
            display: none;
        }

        .search-highlight {
            background-color: #fff3cd;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const clearBtn = document.getElementById('clearBtn');
            const tableBody = document.getElementById('tableBody');
            const recordCount = document.getElementById('recordCount');
            const noResults = document.getElementById('noResults');
            const table = document.getElementById('driversTable');

            // Get total count
            const totalRows = tableBody.querySelectorAll('tr').length;
            updateRecordCount(totalRows);

            // Select all checkbox
            const selectAllCheckbox = document.getElementById('selectAll');
            const driverCheckboxes = document.querySelectorAll('.driver-checkbox');
            const bulkActionContainer = document.getElementById('bulkActionContainer');
            const selectedCount = document.getElementById('selectedCount');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

            function updateBulkActionButton() {
                const checkedCount = Array.from(driverCheckboxes).filter(cb => cb.checked).length;
                if (checkedCount > 0) {
                    selectedCount.textContent = checkedCount;
                    bulkActionContainer.style.display = 'block';
                } else {
                    bulkActionContainer.style.display = 'none';
                }
            }

            selectAllCheckbox.addEventListener('change', function() {
                driverCheckboxes.forEach(checkbox => {
                    // Only check visible checkboxes
                    if (!checkbox.closest('tr').classList.contains('hidden')) {
                        checkbox.checked = this.checked;
                    }
                });
                updateBulkActionButton();
            });

            // Individual checkbox change
            driverCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const visibleCheckboxes = Array.from(driverCheckboxes).filter(cb => !cb.closest(
                        'tr').classList.contains('hidden'));
                    const allChecked = visibleCheckboxes.every(cb => cb.checked);
                    const someChecked = visibleCheckboxes.some(cb => cb.checked);
                    selectAllCheckbox.checked = allChecked;
                    selectAllCheckbox.indeterminate = someChecked && !allChecked;
                    updateBulkActionButton();
                });
            });

            // SweetAlert loader helper
            function ensureSwal() {
                return new Promise((resolve) => {
                    if (window.Swal) {
                        return resolve(window.Swal);
                    }
                    const s = document.createElement('script');
                    s.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
                    s.onload = () => resolve(window.Swal);
                    document.head.appendChild(s);
                });
            }

            // Bulk delete functionality (uses SweetAlert2)
            bulkDeleteBtn.addEventListener('click', function() {
                const selectedIds = Array.from(driverCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                if (selectedIds.length === 0) {
                    ensureSwal().then(() => {
                        Swal.fire({
                            icon: 'info',
                            title: '{{ __('messages.no_selection') ?? 'No selection' }}',
                            text: '{{ __('messages.no_drivers_selected') ?? 'No drivers selected' }}'
                        });
                    });
                    return;
                }

                ensureSwal().then(() => {
                    Swal.fire({
                        title: '{{ __('messages.confirm') ?? 'Confirm' }}',
                        text: `{{ __('messages.confirm_delete_count') ?? 'Are you sure you want to delete' }} ${selectedIds.length} {{ __('messages.drivers') ?? 'driver(s)' }}?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: '{{ __('messages.delete') ?? 'Delete' }}',
                        cancelButtonText: '{{ __('messages.cancel') ?? 'Cancel' }}'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Create a form and submit for bulk delete
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '{{ route('drivers.bulkDestroy') }}';

                            const csrfToken = document.querySelector(
                                'meta[name="csrf-token"]')?.getAttribute(
                                'content');
                            if (csrfToken) {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = '_token';
                                input.value = csrfToken;
                                form.appendChild(input);
                            }

                            const methodInput = document.createElement('input');
                            methodInput.type = 'hidden';
                            methodInput.name = '_method';
                            methodInput.value = 'DELETE';
                            form.appendChild(methodInput);

                            selectedIds.forEach(id => {
                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = 'ids[]';
                                input.value = id;
                                form.appendChild(input);
                            });

                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });

            // Individual delete buttons (use SweetAlert)
            document.querySelectorAll('.confirm-delete-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const message = this.getAttribute('data-confirm-message') ||
                        '{{ __('messages.confirm_delete') ?? 'Are you sure?' }}';
                    const form = this.closest('form');
                    ensureSwal().then(() => {
                        Swal.fire({
                            title: '{{ __('messages.confirm') ?? 'Confirm' }}',
                            text: message,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: '{{ __('messages.delete') ?? 'Delete' }}',
                            cancelButtonText: '{{ __('messages.cancel') ?? 'Cancel' }}'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            });

            // Search functionality
            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase().trim();
                let visibleCount = 0;

                tableBody.querySelectorAll('.driver-row').forEach(row => {
                    const driverId = row.getAttribute('data-driver-id');
                    const driverName = row.getAttribute('data-driver-name');

                    if (!searchTerm || driverId.includes(searchTerm) || driverName.includes(
                            searchTerm)) {
                        row.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        row.classList.add('hidden');
                    }
                });

                // Show/hide no results message
                if (visibleCount === 0 && searchTerm) {
                    noResults.classList.remove('d-none');
                    table.style.display = 'none';
                } else {
                    noResults.classList.add('d-none');
                    table.style.display = '';
                }

                updateRecordCount(visibleCount);
            });

            // Clear button
            clearBtn.addEventListener('click', function() {
                searchInput.value = '';
                tableBody.querySelectorAll('.driver-row').forEach(row => {
                    row.classList.remove('hidden');
                });
                noResults.classList.add('d-none');
                table.style.display = '';
                updateRecordCount(totalRows);
                searchInput.focus();
            });

            function updateRecordCount(count) {
                recordCount.textContent = `Showing ${count} of ${totalRows}`;
            }
        });
    </script>
@endsection
