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
                    <div class="card-title">{{ __('messages.drivers') }}</div>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-danger d-none" id="delete-selected-btn">
                            <i
                                class="ri-delete-bin-line me-1 fw-medium align-middle"></i>{{ __('messages.delete_selected') }}
                            (<span id="selected-count">0</span>)
                        </button>

                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-driver-modal">
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
                                    <th scope="col" id="checkCol" class="no-sort"><input class="form-check-input"
                                            type="checkbox" id="selectAllDrivers" aria-label="Select All"></th>
                                    <th scope="col" id="driverCol" class="no-sort">{{ __('messages.driver') }}</th>
                                    <th scope="col" id="percentageCol" class="no-sort">
                                        {{ __('messages.default_percentage') }}</th>
                                    <th scope="col" id="rentalCol" class="no-sort">
                                        {{ __('messages.default_rental_price') }}</th>
                                    <th scope="col" id="byCol" class="no-sort">{{ __('messages.added_by') }}</th>
                                    <th scope="col" id="actionCol" class="no-sort">{{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <!-- Pagination -->
                        <div class="col-12" id="tableFooterpagination">
                            <nav id="pagenums" aria-label="Page navigation">
                                <ul class="pagination mb-0">
                                    <li class="page-item">
                                        <a class="page-link" href="javascript:void(0);" aria-label="Previous">
                                            <span aria-hidden="true"><i class="bx bx-chevron-left"></i></span>
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
                                    <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                                    <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="javascript:void(0);" aria-label="Next">
                                            <span aria-hidden="true"><i class="bx bx-chevron-right"></i></span>
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
    <div class="modal fade" id="edit-driver-modal" tabindex="-1" aria-labelledby="editDriverModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDriverModalLabel">{{ __('messages.add_driver') }}</h5>
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
                        <button type="submit" class="btn btn-primary">{{ __('messages.add_driver_btn') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
            const tableBody = $('#drivers-table tbody');

            // === LOAD DRIVERS ===
            function loadDrivers(page = 1) {
                $.get("{{ route('drivers.data') }}", {
                    page: page,
                    limit: limit,
                    search: searchTerm
                }, function(response) {
                    const {
                        data,
                        total
                    } = response;
                    tableBody.empty();

                    if (data.length === 0) {
                        tableBody.append(
                            `<tr><td colspan="6" class="text-center text-muted py-4">No drivers found</td></tr>`
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
                    <a class="page-link" href="javascript:void(0);" aria-label="Previous"><i class="bx bx-chevron-left"></i></a>
                </li>
            `);

                for (let i = 1; i <= totalPages; i++) {
                    pagination.append(`
                    <li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="javascript:void(0);">${i}</a>
                    </li>
                `);
                }

                pagination.append(`
                <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="javascript:void(0);" aria-label="Next"><i class="bx bx-chevron-right"></i></a>
                </li>
            `);
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
                }, 400); // debounce 400ms
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

            // === EDIT MODAL ===
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
                    title: 'Are you sure?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/drivers/${driverId}`,
                            type: 'DELETE',
                            success: function(response) {
                                Swal.fire('Deleted!', response.message, 'success');
                                loadDrivers(currentPage);
                            },
                            error: function() {
                                Swal.fire('Error!', 'Could not delete driver.',
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
        });
    </script>
@endsection
