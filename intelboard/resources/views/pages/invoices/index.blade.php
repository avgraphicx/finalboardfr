@extends('layouts.master')

@section('styles')
@endsection

@section('content')
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.upload_invoices') }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a
                        href="{{ route('invoices.index') }}">{{ __('messages.invoices') ?? 'Invoices' }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.upload_invoices') }}</li>
            </ol>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Single Upload Section (shown always) -->
    <div class="row" id="singleUpload">
        <div class="col-12">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">
                        {{ __('messages.select_driver') }}
                    </div>

                </div>

                <div class="card-body">
                    <form id="driverSelectionForm">
                        <p class="text-muted">{{ __('messages.search_by_name_or_driver_id') }}</p>
                        <select name="selected_driver" id="selectedDriver"
                            class="js-example-templating js-persons form-control" required>
                            <option value="">{{ __('messages.select_driver') }}</option>
                            @foreach ($drivers as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->driver_id }} - {{ $driver->full_name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="d-flex gap-2 mt-3">
                            <button type="button" id="nextBtn" class="btn btn-primary">
                                <i class="ri-arrow-right-line"></i> {{ __('messages.next') ?? 'Next' }}
                            </button>
                        </div>
                    </form>

                    <div id="fileUploadSection" style="display: none;">
                        <form id="singleFileForm" action="{{ route('payments.previewBatch') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="driver_id" id="hiddenDriverId">
                            <p class="text-muted">{{ __('messages.upload_invoice_pdf_for_selected_driver') }}</p>
                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.upload_invoices') }}</label>
                                <input class="form-control" id="singlePdfUpload" type="file" name="pdfs[]"
                                    accept=".pdf" required>
                                <div class="form-text">{{ __('messages.drag_and_drop') }}</div>
                            </div>
                            <div class="d-flex gap-2 mt-3">
                                <button type="button" id="backBtn" class="btn btn-secondary">
                                    <i class="ri-arrow-left-line"></i> {{ __('messages.back') ?? 'Back' }}
                                </button>
                                <button type="submit" id="confirmBtn" class="btn btn-primary">
                                    <i class="ri-eye-line"></i> {{ __('messages.preview') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Upload progress container (hidden until upload starts) - simplified spinner -->
    <div id="uploadProgressContainer" style="display:none; margin-top: 1rem;">
        <div class="card custom-card">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">{{ __('messages.loading') ?? 'Loading...' }}</span>
                    </div>
                    <div><strong>{{ __('messages.uploading_files') ?? 'Uploading files, please wait...' }}</strong></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Multi File Upload Section (hidden when max_files = 1) -->
    <div class="row" id="multiFileUploadSection"
        style="display: {{ isset($maxFiles) && $maxFiles == 1 ? 'none' : 'block' }}">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="card-title">{{ __('messages.upload_invoices') }}</div>
                    @if (isset($maxFiles) && $maxFiles > 0)
                        <span class="badge bg-info-transparent">
                            {{ __('messages.max_files_allowed') ?? 'Max Files' }}: {{ $maxFiles }}
                        </span>
                    @endif
                </div>
                <div class="card-body">
                    <form id="multiFileForm" action="{{ route('payments.previewBatch') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.upload_invoices') }}</label>
                            <input class="form-control" id="multiPdfUpload" type="file" name="pdfs[]" multiple
                                accept=".pdf" required>
                            <div class="form-text">{{ __('messages.drag_and_drop') }}</div>
                        </div>
                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-eye-line"></i> {{ __('messages.preview') }}
                            </button>
                            <a href="{{ route('invoices.index') }}" class="btn btn-teal-light">
                                <i class="bi bi-arrow-left-circle-fill"></i> {{ __('messages.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const maxFiles = {{ $maxFiles ?? 0 }};

        document.addEventListener('DOMContentLoaded', function() {
            const nextBtn = document.getElementById('nextBtn');
            const backBtn = document.getElementById('backBtn');
            const selectedDriver = document.getElementById('selectedDriver');
            const driverSelectionForm = document.getElementById('driverSelectionForm');
            const fileUploadSection = document.getElementById('fileUploadSection');
            const singleFileForm = document.getElementById('singleFileForm');
            const hiddenDriverId = document.getElementById('hiddenDriverId');
            const multiFileUploadSection = document.getElementById('multiFileUploadSection');
            const singlePdfUpload = document.getElementById('singlePdfUpload');
            const multiFileForm = document.getElementById('multiFileForm');
            const multiPdfUpload = document.getElementById('multiPdfUpload');

            // Next button - show file upload section
            nextBtn.addEventListener('click', function() {
                if (!selectedDriver.value) {
                    Swal.fire({
                        icon: 'warning',
                        title: '{{ __('messages.warning') }}',
                        text: '{{ __('messages.select_driver') }}',
                    });
                    return;
                }
                hiddenDriverId.value = selectedDriver.value;
                driverSelectionForm.style.display = 'none';
                fileUploadSection.style.display = 'block';
                if (maxFiles != 1) {
                    multiFileUploadSection.style.display = 'none';
                }
            });

            // Back button - return to driver selection
            backBtn.addEventListener('click', function() {
                fileUploadSection.style.display = 'none';
                driverSelectionForm.style.display = 'block';
                if (maxFiles != 1) {
                    multiFileUploadSection.style.display = 'block';
                }
                singlePdfUpload.value = '';
            });

            // Single file form submission (validate then AJAX upload with progress)
            singleFileForm.addEventListener('submit', function(e) {
                e.preventDefault();
                if (!singlePdfUpload.files.length) {
                    Swal.fire({
                        icon: 'warning',
                        title: '{{ __('messages.warning') }}',
                        text: '{{ __('messages.upload_invoices') ?? 'Please select a file' }}',
                    });
                    return;
                }

                // Validate PDF belongs to selected driver via existing endpoint
                const validationData = new FormData();
                validationData.append('pdf', singlePdfUpload.files[0]);
                validationData.append('driver_id', hiddenDriverId.value);
                validationData.append('_token', '{{ csrf_token() }}');

                fetch('{{ route('payments.validateDriverPdf') }}', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: validationData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.valid) {
                            Swal.fire({
                                icon: 'error',
                                title: '{{ __('messages.error') }}',
                                text: data.message || '{{ __('messages.error') ?? 'Error' }}',
                            });
                            return;
                        }

                        // Start AJAX upload with progress UI
                        startAjaxUpload(singleFileForm, new FormData(singleFileForm));
                    })
                    .catch(error => {
                        console.error('Validation error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __('messages.error') }}',
                            text: '{{ __('messages.error') ?? 'An error occurred' }}',
                        });
                    });
            });

            // Multi file form validation and AJAX upload
            if (multiFileForm) {
                multiFileForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const fileCount = multiPdfUpload.files.length;

                    // Check if max_files is set and files exceed the limit
                    if (maxFiles > 0 && fileCount > maxFiles) {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __('messages.too_many_files') ?? 'Too Many Files' }}',
                            text: '{{ __('messages.max_files_exceeded') ?? 'You can only upload' }} ' +
                                maxFiles +
                                ' {{ __('messages.files_at_once') ?? 'files at once' }}',
                            confirmButtonText: '{{ __('messages.ok') ?? 'OK' }}',
                            confirmButtonColor: '#d33'
                        });
                        return;
                    }

                    if (fileCount === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: '{{ __('messages.warning') }}',
                            text: '{{ __('messages.select_files') ?? 'Please select files' }}',
                        });
                        return;
                    }

                    // Start AJAX upload and show progress
                    startAjaxUpload(multiFileForm, new FormData(multiFileForm));
                });

                // Also add change event to show warning immediately
                multiPdfUpload.addEventListener('change', function() {
                    const fileCount = this.files.length;

                    if (maxFiles > 0 && fileCount > maxFiles) {
                        Swal.fire({
                            icon: 'error',
                            title: '{{ __('messages.too_many_files') ?? 'Too Many Files' }}',
                            text: '{{ __('messages.max_files_exceeded') ?? 'You can only upload' }} ' +
                                maxFiles +
                                ' {{ __('messages.files_at_once') ?? 'files at once' }}',
                            confirmButtonText: '{{ __('messages.ok') ?? 'OK' }}',
                            confirmButtonColor: '#d33'
                        });
                        this.value = ''; // Clear the selection
                    }
                });
            }

            // Generic AJAX upload helper (shows spinner only)
            function startAjaxUpload(form, formData) {
                const uploadContainer = document.getElementById('uploadProgressContainer');

                // Hide selection UI
                const singleUploadSection = document.getElementById('singleUpload');
                const multiUploadSection = document.getElementById('multiFileUploadSection');
                if (singleUploadSection) singleUploadSection.style.display = 'none';
                if (multiUploadSection) multiUploadSection.style.display = 'none';

                if (uploadContainer) uploadContainer.style.display = 'flex';

                const xhr = new XMLHttpRequest();
                xhr.open('POST', form.action, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        try {
                            let json = null;
                            try {
                                json = JSON.parse(xhr.responseText);
                            } catch (e) {
                                // not JSON
                            }

                            if (json && json.redirect) {
                                window.location.href = json.redirect;
                                return;
                            }

                            const blob = new Blob([xhr.responseText], {
                                type: 'text/html'
                            });
                            const blobUrl = URL.createObjectURL(blob);
                            window.location.replace(blobUrl);
                            setTimeout(() => URL.revokeObjectURL(blobUrl), 5000);
                        } catch (err) {
                            console.error('Failed to handle upload response:', err);
                            // restore UI
                            if (uploadContainer) uploadContainer.style.display = 'none';
                            if (singleUploadSection) singleUploadSection.style.display = 'block';
                            if (multiUploadSection) multiUploadSection.style.display = 'block';
                            Swal.fire({
                                icon: 'success',
                                title: '{{ __('messages.upload_complete') ?? 'Upload complete' }}',
                            });
                        }
                    } else {
                        handleUploadError(xhr);
                    }
                };

                xhr.onerror = function() {
                    handleUploadError(xhr);
                };

                xhr.send(formData);
            }

            function handleUploadError(xhr) {
                console.error('Upload failed', xhr);
                const uploadContainer = document.getElementById('uploadProgressContainer');
                const singleUploadSection = document.getElementById('singleUpload');
                const multiUploadSection = document.getElementById('multiFileUploadSection');
                if (uploadContainer) uploadContainer.style.display = 'none';
                if (singleUploadSection) singleUploadSection.style.display = 'block';
                if (multiUploadSection) multiUploadSection.style.display = 'block';

                Swal.fire({
                    icon: 'error',
                    title: '{{ __('messages.upload_failed') ?? 'Upload failed' }}',
                    text: '{{ __('messages.error') ?? 'An error occurred during upload' }}',
                });
            }
        });
    </script>
@endsection
