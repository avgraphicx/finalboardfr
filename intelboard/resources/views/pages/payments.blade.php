@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://unpkg.com/filepond@4/dist/filepond.min.css" />
    <link rel="stylesheet"
        href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css" />
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

    <div class="row" id="mainDiv">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="card-title">{{ __('messages.upload_invoices') }}</div>
                </div>
                <div class="card-body">
                    <input type="file" id="pdfInvoices" class="filepond" name="filepond" multiple accept=".pdf" />
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Progress Container (hidden by default) -->
    <div class="row" id="progressDiv" style="display: none;">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title" id="uploadTitle">{{ __('messages.upload_title_invoices', ['count' => 0]) }}
                    </div>
                </div>
                <div class="card-body">
                    <div class="progress progress-lg mb-5 custom-progress-3 progress-animate" id="progressContainer"
                        role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" id="progressBar" style="width: 0%">
                            <div class="progress-bar-value" id="progressValue">0%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Complete Container (hidden by default) -->
    <div class="row" id="completeDiv" style="display: none;">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">{{ __('messages.upload_complete') }}</div>
                </div>
                <div class="card-body">
                    <div id="completeContent"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/filepond@4/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js">
    </script>

    <script>
        // Register FilePond plugins
        FilePond.registerPlugin(FilePondPluginFileValidateSize);

        let totalFiles = 0;
        let completedFiles = 0;
        let uploadedData = [];
        let driversFound = [];
        let driversNotFound = [];
        let filesMap = {}; // Store file objects by driver_id+week_number

        // Initialize FilePond
        const pond = FilePond.create(
            document.getElementById('pdfInvoices'), {
                allowMultiple: true,
                maxFiles: 9999,
                maxFileSize: '25MB',
                labelIdle: '{{ __('messages.drag_and_drop') }} <span class="filepond--label-action">{{ __('messages.browse') }}</span>',
                onaddfile: (error, file) => {
                    if (!error) {
                        totalFiles = pond.getFiles().length;
                        completedFiles = 0;
                        uploadedData = [];
                        driversFound = [];
                        driversNotFound = [];
                        filesMap = {}; // Reset files map

                        // Hide main div and show progress div
                        document.getElementById('mainDiv').style.display = 'none';
                        document.getElementById('progressDiv').style.display = 'block';
                        document.getElementById('completeDiv').style.display = 'none';
                        const uploadTitle = '{{ __('messages.upload_title_invoices', ['count' => '']) }}'.replace(
                            ':count', totalFiles);
                        document.getElementById('uploadTitle').textContent = uploadTitle;
                        updateProgressBar();
                    }
                },
                server: {
                    process: (fieldName, file, metadata, load, error, progress) => {
                        // Validate file extension
                        if (!file.name.toLowerCase().endsWith('.pdf')) {
                            error('{{ __('messages.upload_only_pdf') }}');
                            return;
                        }

                        const formData = new FormData();
                        formData.append('pdf_path', file, file.name);
                        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                        // Add flag to prevent saving to DB during preview
                        formData.append('preview_only', '1');

                        fetch('{{ route('payments.store') }}', {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                                body: formData
                            })
                            .then(response => {
                                const httpStatus = response.status;
                                if (!response.ok && response.status !== 422 && response.status !== 404) {
                                    throw new Error(`HTTP error! status: ${response.status}`);
                                }
                                return response.text().then(text => ({
                                    status: httpStatus,
                                    text: text
                                }));
                            })
                            .then(({
                                status,
                                text
                            }) => {
                                try {
                                    return {
                                        status: status,
                                        data: JSON.parse(text)
                                    };
                                } catch (e) {
                                    throw new Error('{{ __('messages.error_processing_response') }}');
                                }
                            })
                            .then(({
                                status,
                                data
                            }) => {
                                completedFiles++;
                                updateProgressBar();

                                if (data.success) {
                                    uploadedData.push({
                                        fileName: file.name,
                                        success: true,
                                        data: data.data,
                                        file: file // Store the file object
                                    });
                                    // Store file by unique key
                                    const fileKey = `${data.data.driver_id}_${data.data.week_number}`;
                                    filesMap[fileKey] = file;
                                    driversFound.push(data.data);
                                    load(data);
                                } else {
                                    // Check if it's a driver not found error (404 status or message contains "not found")
                                    if (status === 404 || data.message.includes('not found')) {
                                        const driverId = data.data?.driver_id || 'Unknown';
                                        uploadedData.push({
                                            fileName: file.name,
                                            success: false,
                                            driverNotFound: true,
                                            driverId: driverId
                                        });
                                        driversNotFound.push({
                                            driverId: driverId,
                                            fileName: file.name
                                        });
                                    } else {
                                        uploadedData.push({
                                            fileName: file.name,
                                            success: false,
                                            message: data.message
                                        });
                                    }
                                    error(data.message);
                                }

                                // Check if all files are processed
                                if (completedFiles === totalFiles) {
                                    showCompletionScreen();
                                }
                            })
                            .catch(err => {
                                completedFiles++;
                                updateProgressBar();
                                uploadedData.push({
                                    fileName: file.name,
                                    success: false,
                                    message: err.message
                                });
                                error(`{{ __('messages.upload_failed') }}: ${err.message}`);

                                if (completedFiles === totalFiles) {
                                    showCompletionScreen();
                                }
                            });
                    },
                    revert: (uniqueFileId, load, error) => {
                        load();
                    }
                }
            }
        );

        function updateProgressBar() {
            const percentage = totalFiles > 0 ? (completedFiles / totalFiles) * 100 : 0;
            document.getElementById('progressBar').style.width = percentage + '%';
            document.getElementById('progressValue').textContent = Math.round(percentage) + '%';
            document.getElementById('progressContainer').setAttribute('aria-valuenow', Math.round(percentage));
        }

        function showCompletionScreen() {
            document.getElementById('progressDiv').style.display = 'none';
            document.getElementById('completeDiv').style.display = 'block';

            let content = `<div class="mb-4">`;

            // Drivers found section
            content += `<h5 class="mb-3">${driversFound.length} {{ __('messages.drivers_found') }}</h5>`;
            if (driversFound.length > 0) {
                content += `<div class="alert alert-success mb-4">`;
                driversFound.forEach(driver => {
                    content += `<div>${driver.driver_id} - ${driver.driver_full_name}</div>`;
                });
                content += `</div>`;
            }

            // Drivers not found section
            if (driversNotFound.length > 0) {
                content +=
                    `<h5 class="mb-3">${driversNotFound.length} {{ __('messages.drivers_not_found') }}${driversNotFound.length !== 1 ? 's' : ''}:</h5>`;
                content += `<div class="alert alert-warning mb-4">
                    <ul class="mb-0">`;
                driversNotFound.forEach(item => {
                    content += `<li>${item.driverId}</li>`;
                });
                content += `</ul></div>`;
            }

            content += `</div>`;
            content += `<button class="btn btn-success form-control" onclick="confirmAndSave()">
                <i class="ri-check-line"></i> {{ __('messages.proceed_with_count', ['count' => '']) }} ${driversFound.length}
            </button>`;

            document.getElementById('completeContent').innerHTML = content;
        }

        function confirmAndSave() {
            // Show confirmation
            Swal.fire({
                title: '{{ __('messages.confirm_upload_title') }}',
                text: `{{ __('messages.confirm_upload_text', ['count' => '']) }}`.replace(':count', driversFound
                    .length),
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '{{ __('messages.confirm_yes_save') }}',
                cancelButtonText: '{{ __('messages.confirm_no_cancel') }}',
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    saveToDatabase();
                }
            });
        }

        function saveToDatabase() {
            // Show loading state
            Swal.fire({
                title: '{{ __('messages.saving_title') }}',
                text: '{{ __('messages.saving_text') }}',
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: (modal) => {
                    Swal.showLoading();
                }
            });

            // Re-upload each file without preview_only to actually save to DB
            let saveCount = 0;
            let failCount = 0;

            driversFound.forEach((driverData, index) => {
                // Get the file from filesMap using the same key
                const fileKey = `${driverData.driver_id}_${driverData.week_number}`;
                const file = filesMap[fileKey];

                if (file) {
                    // Create FormData with file and without preview_only flag
                    const saveFormData = new FormData();
                    saveFormData.append('pdf_path', file, file.name);
                    saveFormData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                    // NO preview_only flag - this will trigger actual save to DB

                    fetch('{{ route('payments.store') }}', {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            body: saveFormData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                saveCount++;
                            } else {
                                failCount++;
                            }

                            // Check if all files are saved
                            if (saveCount + failCount === driversFound.length) {
                                showSaveResult(saveCount, failCount);
                            }
                        })
                        .catch(err => {
                            failCount++;

                            if (saveCount + failCount === driversFound.length) {
                                showSaveResult(saveCount, failCount);
                            }
                        });
                } else {
                    failCount++;
                    if (saveCount + failCount === driversFound.length) {
                        showSaveResult(saveCount, failCount);
                    }
                }
            });

            // If no files to process, show error
            if (driversFound.length === 0) {
                Swal.fire({
                    title: '{{ __('messages.no_data_to_save') }}',
                    icon: 'error',
                    confirmButtonText: '{{ __('messages.ok') }}'
                });
            }
        }

        function showSaveResult(saveCount, failCount) {
            if (failCount === 0) {
                Swal.fire({
                    title: '{{ __('messages.success_title') }}',
                    text: `{{ __('messages.success_text', ['count' => '']) }}`.replace(':count', saveCount),
                    icon: 'success',
                    confirmButtonText: '{{ __('messages.go_to_drivers_page') }}'
                }).then(() => {
                    window.location.href = '{{ route('drivers.index') }}';
                });
            } else {
                Swal.fire({
                    title: '{{ __('messages.partially_saved_title') }}',
                    text: `{{ __('messages.partially_saved_text', ['saved' => '', 'failed' => '']) }}`.replace(
                        ':saved', saveCount).replace(':failed', failCount),
                    icon: 'warning',
                    confirmButtonText: '{{ __('messages.go_to_drivers_page') }}'
                }).then(() => {
                    window.location.href = '{{ route('drivers.index') }}';
                });
            }
        }

        function resetUpload() {
            totalFiles = 0;
            completedFiles = 0;
            uploadedData = [];
            driversFound = [];
            driversNotFound = [];
            filesMap = {};

            pond.removeFiles();

            document.getElementById('mainDiv').style.display = 'block';
            document.getElementById('progressDiv').style.display = 'none';
            document.getElementById('completeDiv').style.display = 'none';
        }
    </script>
@endsection
