@extends('layouts.master')

@section('styles')
    {{-- Using modern CDN links that you provided --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
@endsection

@section('content')
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.drivers') }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('messages.dashboard_menu') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.drivers') }}</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="card-title">{{ __('messages.total_drivers') }} : {{ $driversCount }}</div>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-danger d-none" id="delete-selected-btn">
                            <i
                                class="ri-delete-bin-line me-1 fw-medium align-middle"></i>{{ __('messages.delete_selected') }}
                            (<span id="selected-count">0</span>)
                        </button>

                        <button class="btn btn-outline-success" id="filter-active-btn">
                            <i
                                class="ri-check-double-line me-1 fw-medium align-middle"></i>{{ __('messages.show_active_only') }}
                        </button>

                        @php
                            $currentDrivers = $driversCount;
                            $userSubscription = auth()->user()->subscription;
                            $maxDrivers = $userSubscription
                                ? $userSubscription->subscriptionType->max_drivers
                                : PHP_INT_MAX;
                        @endphp
                        <button id="open-create-driver" class="btn btn-primary" data-current-drivers="{{ $currentDrivers }}"
                            data-max-drivers="{{ $maxDrivers }}">
                            <i class="ri-add-line me-1 fw-medium align-middle"></i>{{ __('messages.add_driver_btn') }}
                        </button>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <div class="col-12 mb-3 mt-3 me-3" id="custom-search-wrapper">
                            <div class="input-group">
                                <div class="input-group-text text-muted"> <i class="ri-search-line"></i> </div>
                                <input type="text" class="form-control" id="custom-search-input"
                                    placeholder="{{ __('messages.search_placeholder') }}">
                            </div>
                        </div>
                        <table id="drivers-table" class="table text-nowrap table-hover table-striped">
                            <thead>
                                <tr>
                                    <th id="checkCol" scope="col"><input class="form-check-input" type="checkbox"
                                            id="selectAllDrivers" aria-label="{{ __('messages.select_all') }}"></th>
                                    <th id="driverCol" scope="col">{{ __('messages.driver') }}</th>
                                    <th scope="col">{{ __('messages.default_percentage') }}</th>
                                    <th scope="col">{{ __('messages.default_rental_price') }}</th>
                                    <th scope="col">{{ __('messages.added_by') }}</th>
                                    <th id="actionCol" scope="col">{{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="col-12" id="tableFooterpagination">
                            <nav id="pagenums" aria-label="Page navigation">
                                <ul class="pagination mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="javascript:void(0);" aria-label="Previous">
                                            <span aria-hidden="true"><i class="bx bx-chevron-left"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- === EDIT MODAL === --}}
    <div class="modal fade" id="edit-driver-modal" tabindex="-1" aria-labelledby="editDriverModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDriverModalLabel">{{ __('messages.edit_driver') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="{{ __('messages.close') }}"></button>
                </div>
                <div class="modal-body">
                    <form id="edit-driver-form">
                        <div class="mb-3">
                            <label for="edit-driver-name" class="form-label">{{ __('messages.full_name') }}</label>
                            <input type="text" class="form-control" id="edit-driver-name" name="full_name">
                        </div>
                        <div class="mb-3">
                            <label for="edit-driver-id" class="form-label">{{ __('messages.driver_id') }}</label>
                            <input type="text" class="form-control" id="edit-driver-id" name="driver_id">
                        </div>
                        <div class="mb-3">
                            <label for="edit-driver-phone" class="form-label">{{ __('messages.phone_number') }}</label>
                            <input type="text" class="form-control" id="edit-driver-phone" name="phone_number">
                        </div>
                        <div class="mb-3">
                            <label for="edit-driver-ssn" class="form-label">{{ __('messages.ssn') }}</label>
                            <input type="text" class="form-control" id="edit-driver-ssn" name="ssn">
                        </div>
                        <div class="mb-3">
                            <label for="edit-driver-license"
                                class="form-label">{{ __('messages.license_number') }}</label>
                            <input type="text" class="form-control" id="edit-driver-license" name="license_number">
                        </div>
                        <div class="mb-3">
                            <label for="edit-driver-percentage"
                                class="form-label">{{ __('messages.default_percentage') }}</label>
                            <input type="number" class="form-control" id="edit-driver-percentage"
                                name="default_percentage">
                        </div>
                        <div class="mb-3">
                            <label for="edit-driver-rental"
                                class="form-label">{{ __('messages.default_rental_price') }}</label>
                            <input type="number" class="form-control" id="edit-driver-rental"
                                name="default_rental_price">
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="edit-driver-active" name="active">
                            <label class="form-check-label"
                                for="edit-driver-active">{{ __('messages.driver_active') }}</label>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('messages.save_changes') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- === CREATE MODAL === --}}
    <div class="modal fade" id="create-driver-modal" tabindex="-1" aria-labelledby="createDriverModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createDriverModalLabel">{{ __('messages.add_driver') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="{{ __('messages.close') }}"></button>
                </div>
                <div class="modal-body">
                    <form id="create-driver-form">
                        <div class="mb-3">
                            <label for="create-driver-name" class="form-label">{{ __('messages.full_name') }}</label>
                            <input type="text" class="form-control" id="create-driver-name" name="full_name">
                        </div>
                        <div class="mb-3">
                            <label for="create-driver-id" class="form-label">{{ __('messages.driver_id') }}</label>
                            <input type="text" class="form-control" id="create-driver-id" name="driver_id">
                        </div>
                        <div class="mb-3">
                            <label for="create-driver-phone" class="form-label">{{ __('messages.phone_number') }}</label>
                            <input type="text" class="form-control" id="create-driver-phone" name="phone_number">
                        </div>
                        <div class="mb-3">
                            <label for="create-driver-ssn" class="form-label">{{ __('messages.ssn') }}</label>
                            <input type="text" class="form-control" id="create-driver-ssn" name="ssn">
                        </div>
                        <div class="mb-3">
                            <label for="create-driver-license"
                                class="form-label">{{ __('messages.license_number') }}</label>
                            <input type="text" class="form-control" id="create-driver-license" name="license_number">
                        </div>
                        <div class="mb-3">
                            <label for="create-driver-percentage"
                                class="form-label">{{ __('messages.default_percentage') }}</label>
                            <input type="number" class="form-control" id="create-driver-percentage"
                                name="default_percentage">
                        </div>
                        <div class="mb-3">
                            <label for="create-driver-rental"
                                class="form-label">{{ __('messages.default_rental_price') }}</label>
                            <input type="number" class="form-control" id="create-driver-rental"
                                name="default_rental_price">
                        </div>
                        <button type="submit"
                            class="form-control btn btn-primary">{{ __('messages.add_driver_btn') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            let currentPage = 1;
            const limit = 10;
            let searchTerm = '';
            let showActiveOnly = false;
            const tableBody = $('#drivers-table tbody');

            // === LOAD DRIVERS ===
            function loadDrivers(page = 1) {
                $.get("{{ route('drivers.data') }}", {
                    page: page,
                    limit: limit,
                    search: searchTerm,
                    active_only: showActiveOnly
                }, function(response) {
                    const {
                        data,
                        total
                    } = response;
                    tableBody.empty();

                    if (data.length === 0) {
                        tableBody.append(
                            `<tr><td colspan="6" class="text-center text-muted py-4">{{ __('messages.no_drivers_found') }}</td></tr>`
                        );
                    } else {
                        data.forEach(driver => {
                            const row = `
                            <tr>
                                <td><input class="form-check-input select-driver-checkbox" type="checkbox" value="${driver.id}"></td>
                                <td>
                                    <div class="fw-bold">${driver.full_name}</div>
                                    <div class="text-muted fs-11">${driver.driver_id}</div>
                                </td>
                                <td>${driver.default_percentage}%</td>
                                <td>$${Number(driver.default_rental_price).toFixed(2)}</td>
                                <td>${driver.added_by_name}</td>
                                <td>
                                    <div class="hstack gap-2 fs-15">
                                        <a href="/drivers/${driver.id}" class="btn btn-icon btn-sm btn-primary"><i class="ri-eye-line"></i></a>
                                        <a href="javascript:void(0);" data-id="${driver.id}" class="btn btn-icon btn-sm btn-warning edit-driver-btn"><i class="ri-edit-line"></i></a>
                                        <a href="javascript:void(0);" data-id="${driver.id}" class="btn btn-icon btn-sm btn-danger delete-driver-btn"><i class="ri-delete-bin-line"></i></a>
                                    </div>
                                </td>
                            </tr>`;
                            tableBody.append(row);
                        });
                    }

                    renderPagination(total, page);
                });
            }

            // === PAGINATION RENDER ===
            function renderPagination(total, currentPage) {
                const totalPages = Math.ceil(total / limit);
                const pagination = $('#pagenums ul');
                pagination.empty();

                pagination.append(`
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="javascript:void(0);" aria-label="{{ __('messages.previous') }}"><i class="bx bx-chevron-left"></i></a>
                </li>`);

                for (let i = 1; i <= totalPages; i++) {
                    pagination.append(`
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="javascript:void(0);">${i}</a>
                    </li>`);
                }

                pagination.append(`
                <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="javascript:void(0);" aria-label="{{ __('messages.next') }}"><i class="bx bx-chevron-right"></i></a>
                </li>`);
            }

            // === PAGINATION HANDLER ===
            $('#pagenums').on('click', '.page-link', function() {
                const label = $(this).attr('aria-label');
                const active = $('#pagenums .page-item.active a').text();
                let page = parseInt(active);

                if (label === 'Previous' && page > 1) page--;
                else if (label === 'Next') page++;
                else if (!isNaN($(this).text())) page = parseInt($(this).text());

                currentPage = page;
                loadDrivers(page);
            });

            // === SEARCH INPUT ===
            let searchTimer = null;
            $('#custom-search-input').on('keyup', function() {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    searchTerm = $(this).val().trim();
                    currentPage = 1;
                    loadDrivers(currentPage);
                }, 400);
            });

            // === ACTIVE FILTER TOGGLE ===
            $('#filter-active-btn').on('click', function() {
                showActiveOnly = !showActiveOnly;
                currentPage = 1;
                $(this)
                    .toggleClass('btn-outline-success', !showActiveOnly)
                    .toggleClass('btn-success', showActiveOnly)
                    .html(showActiveOnly ?
                        '<i class="ri-filter-line me-1"></i>{{ __('messages.show_all_drivers') }}' :
                        '<i class="ri-check-double-line me-1"></i>{{ __('messages.show_active_only') }}');
                loadDrivers(currentPage);
            });

            // === CREATE DRIVER ===
            $('#create-driver-form').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();

                $.post('{{ route('drivers.store') }}', formData)
                    .done(function(response) {
                        Swal.fire('Success!', response.message, 'success');
                        $('#create-driver-modal').modal('hide');
                        loadDrivers(currentPage);
                    })
                    .fail(function(xhr) {
                        const errors = xhr.responseJSON?.errors || {};
                        let msg = Object.values(errors).flat().join('\n') || 'Unexpected error.';
                        Swal.fire('Error!', msg, 'error');
                    });
            });

            // === EDIT DRIVER ===
            $('#drivers-table').on('click', '.edit-driver-btn', function() {
                const driverId = $(this).data('id');
                $.get(`/drivers/${driverId}/edit`, function(data) {
                    $('#edit-driver-name').val(data.full_name);
                    $('#edit-driver-id').val(data.driver_id);
                    $('#edit-driver-phone').val(data.phone_number);
                    $('#edit-driver-ssn').val(data.ssn);
                    $('#edit-driver-license').val(data.license_number);
                    $('#edit-driver-percentage').val(data.default_percentage);
                    $('#edit-driver-rental').val(data.default_rental_price);
                    $('#edit-driver-active').prop('checked', data.active);
                    $('#edit-driver-modal').modal('show');
                });
            });

            // === DELETE DRIVER ===
            $('#drivers-table').on('click', '.delete-driver-btn', function() {
                const driverId = $(this).data('id');
                Swal.fire({
                    title: '{{ __('messages.confirm_delete_title') }}',
                    text: '{{ __('messages.confirm_delete_text') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '{{ __('messages.confirm_delete_yes') }}',
                    cancelButtonText: '{{ __('messages.cancel') }}'
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/drivers/${driverId}`,
                            type: 'DELETE',
                            success: function(response) {
                                Swal.fire('{{ __('messages.deleted_title') }}',
                                    response.message, 'success');
                                loadDrivers(currentPage);
                            },
                            error: function() {
                                Swal.fire('{{ __('messages.error_title') }}',
                                    '{{ __('messages.driver_delete_error_js') }}',
                                    'error');
                            }
                        });
                    }
                });
            });

            // === SELECT ALL CHECKBOXES ===
            $('#selectAllDrivers').on('change', function() {
                const checked = $(this).is(':checked');
                $('.select-driver-checkbox').prop('checked', checked);
                toggleDeleteSelectedButton();
            });

            $('#drivers-table').on('change', '.select-driver-checkbox', toggleDeleteSelectedButton);

            function toggleDeleteSelectedButton() {
                const count = $('.select-driver-checkbox:checked').length;
                $('#selected-count').text(count);
                $('#delete-selected-btn').toggleClass('d-none', count === 0);
            }

            // === INITIAL LOAD ===
            loadDrivers(currentPage);

            $('#open-create-driver').on('click', function() {
                const current = parseInt(this.dataset.currentDrivers, 10);
                const max = parseInt(this.dataset.maxDrivers, 10);
                if (current >= max) {
                    Swal.fire({
                        icon: 'error',
                        title: '{{ __('messages.max_drivers_reached') }}',
                        // use raw JSON-encoded string to preserve apostrophe
                        text: @json(__('messages.max_drivers_text', ['max' => ''])).replace(':max', max),
                        confirmButtonText: '{{ __('messages.ok') }}'
                    });
                } else {
                    $('#create-driver-modal').modal('show');
                }
            });
        });
    </script>
@endsection
