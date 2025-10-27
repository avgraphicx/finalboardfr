@extends('layouts.master')

@section('styles')
@endsection

@section('content')
    <!-- Start::page-header -->
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.empty') }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('messages.pages') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.empty') }}</li>
            </ol>
        </div>
    </div>
    <!-- End::page-header -->

    <!-- Start::row-1 -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-body">
                    <h6 class="mb-0">{{ __('messages.empty_card') }}</h6>
                </div>
            </div>
        </div>
    </div>
    <!--End::row-1 -->
@endsection

@section('scripts')
@endsection
