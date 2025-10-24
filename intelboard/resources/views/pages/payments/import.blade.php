@extends('layouts.master')

@section('styles')
@endsection

@section('content')
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.upload_invoices') }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a
                        href="{{ route('invoices.index') }}">{{ __('messages.payments_page_label') }}</a></li>
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

    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="card-title">{{ __('messages.upload_invoices') }}</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('payments.previewBatch') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('messages.upload_invoices') }}</label>
                            <input class="form-control" type="file" name="pdfs[]" multiple accept=".pdf" required>
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
@endsection
