@extends('layouts.master')

@section('styles')
    {{-- Using modern CDN links that you provided --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
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
    {{-- <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="card-title"><b><i id="active"
                                class="bi bi-circle-fill @if ($driver->active == 0) text-danger @endif @if ($driver->active == 1) text-success @endif"></i>
                            {{ $driver->driver_id }}</b> -
                        {{ $driver->full_name }}</div>
                    <div class="d-flex flex-wrap gap-2">

                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="row p-4">
                        <div class="col-xl-6">
                            <p class="lead mb-0"><i class="bi bi-phone"></i> {{ $driver->phone_number }}</p> <br>
                            <p class="lead mb-0"><i class="bi bi-person-vcard"></i> {{ $driver->license_number }}</p> <br>
                            <p class="lead mb-0"><i class="bi bi-person-vcard"></i>
                                <span id="ssn" data-full="{{ $driver->ssn }}">
                                    {{ str_repeat('•', strlen($driver->ssn)) }}
                                </span>
                                <button id="toggle-ssn" class="btn btn-sm btn-link text-light p-0 ms-1">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </p>
                        </div>
                        <div class="col-xl-6">
                            zz

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row mb-5">
        <div class="col-xl-3">
            <div class="card custom-card">
                <div class="card-body text-center p-4">
                    @php
                        // // Generate random background color
                        // $colors = [
                        //     'bg-primary',
                        //     'bg-success',
                        //     'bg-warning',
                        //     'bg-danger',
                        //     'bg-info',
                        //     'bg-secondary',
                        //     'bg-dark',
                        // ];
                        // $randomColor = $colors[array_rand($colors)];

                        // Extract initials from full_name
                        $nameParts = explode(' ', trim($driver->full_name));
                        $initials = '';
                        foreach ($nameParts as $part) {
                            if (!empty($part)) {
                                $initials .= strtoupper(substr($part, 0, 1));
                            }
                        }
                        $initials = substr($initials, 0, 2); // Limit to 2 initials
                    @endphp
                    <span class="avatar avatar-xxl avatar-rounded bg-primary text-light">
                        {{-- <span class="avatar avatar-xxl avatar-rounded {{ $randomColor }}"> --}}
                        <span class="avatar-text fw-bold fs-5" style="color: white !important;">{{ $initials }}</span>
                        <span id="active"
                            class="badge rounded-pill  @if ($driver->active == 0) bg-danger @endif
                            @if ($driver->active == 1) bg-success @endif avatar-badge"></span>

                    </span>

                    <h6 class="fw-semibold mt-3 mb-1">{{ $driver->driver_id }} - {{ $driver->full_name }}</h6>

                    <p>
                    <ul class="nav nav-tabs flex-column nav-tabs-header mb-0 mail-sesttings-tab" role="tablist">
                        <li class="nav-item m-1 text-success" id="protab">
                            <a href="javascript:void(0)" class="pe-none text-success fw-medium nav-link active"
                                tabindex="-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M222.37,158.46l-47.11-21.11-.13-.06a16,16,0,0,0-15.17,1.4,8.12,8.12,0,0,0-.75.56L134.87,160c-15.42-7.49-31.34-23.29-38.83-38.51l20.78-24.71c.2-.25.39-.5.57-.77a16,16,0,0,0,1.32-15.06l0-.12L97.54,33.64a16,16,0,0,0-16.62-9.52A56.26,56.26,0,0,0,32,80c0,79.4,64.6,144,144,144a56.26,56.26,0,0,0,55.88-48.92A16,16,0,0,0,222.37,158.46ZM176,208A128.14,128.14,0,0,1,48,80,40.2,40.2,0,0,1,82.87,40a.61.61,0,0,0,0,.12l21,47L83.2,111.86a6.13,6.13,0,0,0-.57.77,16,16,0,0,0-1,15.7c9.06,18.53,27.73,37.06,46.46,46.11a16,16,0,0,0,15.75-1.14,8.44,8.44,0,0,0,.74-.56L168.89,152l47,21.05h0s.08,0,.11,0A40.21,40.21,0,0,1,176,208Z">
                                    </path>
                                </svg>
                                {{ $driver->phone_number }}
                            </a>
                        </li>
                        <li class="nav-item m-1" id="protab2">
                            <a href="javascript:void(0)" class="pe-none text-primary fw-medium nav-link" tabindex="-1">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                    <rect width="256" height="256" fill="none" />
                                    <path
                                        d="M216,48H40a8,8,0,0,0-8,8V200a8,8,0,0,0,8,8H216a8,8,0,0,0,8-8V56A8,8,0,0,0,216,48ZM96,144a24,24,0,1,1,24-24A24,24,0,0,1,96,144Z"
                                        opacity="0.2" />
                                    <line x1="152" y1="112" x2="192" y2="112" fill="none"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="16" />
                                    <line x1="152" y1="144" x2="192" y2="144" fill="none"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="16" />
                                    <rect x="32" y="48" width="192" height="160" rx="8" fill="none"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="16" />
                                    <circle cx="96" cy="120" r="24" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                    <path d="M64,168c3.55-13.8,17.09-24,32-24s28.46,10.19,32,24" fill="none"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="16" />
                                </svg>
                                {{ $driver->license_number }}
                            </a>
                        </li>
                        <li class="nav-item m-1" id="protab2">
                            <a href="javascript:void(0)"
                                class="text-primary fw-medium nav-link cursor-pointer d-flex align-items-center gap-2"
                                tabindex="0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M72,128a134.63,134.63,0,0,1-14.16,60.47,8,8,0,1,1-14.32-7.12A118.8,118.8,0,0,0,56,128,71.73,71.73,0,0,1,83,71.8,8,8,0,1,1,93,84.29,55.76,55.76,0,0,0,72,128Zm56-8a8,8,0,0,0-8,8,184.12,184.12,0,0,1-23,89.1,8,8,0,0,0,14,7.76A200.19,200.19,0,0,0,136,128,8,8,0,0,0,128,120Zm0-32a40,40,0,0,0-40,40,8,8,0,0,0,16,0,24,24,0,0,1,48,0,214.09,214.09,0,0,1-20.51,92A8,8,0,1,0,146,226.83,230,230,0,0,0,168,128,40,40,0,0,0,128,88Zm0-64A104.11,104.11,0,0,0,24,128a87.76,87.76,0,0,1-5,29.33,8,8,0,0,0,15.09,5.33A103.9,103.9,0,0,0,40,128a88,88,0,0,1,176,0,282.24,282.24,0,0,1-5.29,54.45,8,8,0,0,0,6.3,9.4,8.22,8.22,0,0,0,1.55.15,8,8,0,0,0,7.84-6.45A298.37,298.37,0,0,0,232,128,104.12,104.12,0,0,0,128,24ZM94.4,152.17A8,8,0,0,0,85,158.42a151,151,0,0,1-17.21,45.44,8,8,0,0,0,13.86,8,166.67,166.67,0,0,0,19-50.25A8,8,0,0,0,94.4,152.17ZM128,56a72.85,72.85,0,0,0-9,.56,8,8,0,0,0,2,15.87A56.08,56.08,0,0,1,184,128a252.12,252.12,0,0,1-1.92,31A8,8,0,0,0,189,168a8.39,8.39,0,0,0,1,.06,8,8,0,0,0,7.92-7,266.48,266.48,0,0,0,2-33A72.08,72.08,0,0,0,128,56Zm57.93,128.25a8,8,0,0,0-9.75,5.75c-1.46,5.69-3.15,11.4-5,17a8,8,0,0,0,5,10.13,7.88,7.88,0,0,0,2.55.42,8,8,0,0,0,7.58-5.46c2-5.92,3.79-12,5.35-18.05A8,8,0,0,0,185.94,184.26Z">
                                    </path>
                                </svg>
                                <span class="ssn-value" data-ssn="{{ $driver->ssn }}">**********</span>
                                <svg class="ssn-toggle-icon" xmlns="http://www.w3.org/2000/svg" width="20"
                                    height="20" fill="currentColor" viewBox="0 0 256 256">
                                    <path
                                        d="M247.31,124.76c-.35-.79-8.82-19.58-27.65-38.41C194.57,61.89,162.88,48,128,48S61.43,61.89,36.34,86.35C17.51,105.18,9,124,8.69,124.76a8,8,0,0,0,0,6.5c.35.79,8.82,19.57,27.65,38.4C33.43,194.11,65.12,208,100,208s66.57-13.89,91.66-38.34c18.83-18.83,27.3-37.61,27.65-38.4A8,8,0,0,0,247.31,124.76ZM128,192c-30.78,0-57.67-11.19-79.93-33.25A133.47,133.47,0,0,1,25,128a133.33,133.33,0,0,1,23.07-30.75C73.33,75.19,100.22,64,128,64c30.78,0,57.67,11.19,79.93,33.25A133.46,133.46,0,0,1,231,128a133.37,133.37,0,0,1-23.07,30.75C182.67,180.81,155.78,192,128,192Zm0-112a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Z">
                                    </path>
                                </svg>
                            </a>
                        </li>
                        <li class="nav-item m-1" id="protab2">
                            <a href="javascript:void(0)" class="pe-none text-primary fw-medium nav-link" tabindex="-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M225.86,102.82c-3.77-3.94-7.67-8-9.14-11.57-1.36-3.27-1.44-8.69-1.52-13.94-.15-9.76-.31-20.82-8-28.51s-18.75-7.85-28.51-8c-5.25-.08-10.67-.16-13.94-1.52-3.56-1.47-7.63-5.37-11.57-9.14C146.28,23.51,138.44,16,128,16s-18.27,7.51-25.18,14.14c-3.94,3.77-8,7.67-11.57,9.14C88,40.64,82.56,40.72,77.31,40.8c-9.76.15-20.82.31-28.51,8S41,67.55,40.8,77.31c-.08,5.25-.16,10.67-1.52,13.94-1.47,3.56-5.37,7.63-9.14,11.57C23.51,109.73,16,117.56,16,128s7.51,18.27,14.14,25.18c3.77,3.94,7.67,8,9.14,11.57,1.36,3.27,1.44,8.69,1.52,13.94.15,9.76.31,20.82,8,28.51s18.75,7.85,28.51,8c5.25.08,10.67.16,13.94,1.52,3.56,1.47,7.63,5.37,11.57,9.14C109.72,232.49,117.56,240,128,240s18.27-7.51,25.18-14.14c3.94-3.77,8-7.67,11.57-9.14,3.27-1.36,8.69-1.44,13.94-1.52,9.76-.15,20.82-.31,28.51-8s7.85-18.75,8-28.51c.08-5.25.16-10.67,1.52-13.94,1.47-3.56,5.37-7.63,9.14-11.57C232.49,146.27,240,138.44,240,128S232.49,109.73,225.86,102.82Zm-11.55,39.29c-4.79,5-9.75,10.17-12.38,16.52-2.52,6.1-2.63,13.07-2.73,19.82-.1,7-.21,14.33-3.32,17.43s-10.39,3.22-17.43,3.32c-6.75.1-13.72.21-19.82,2.73-6.35,2.63-11.52,7.59-16.52,12.38S132,224,128,224s-9.15-4.92-14.11-9.69-10.17-9.75-16.52-12.38c-6.1-2.52-13.07-2.63-19.82-2.73-7-.1-14.33-.21-17.43-3.32s-3.22-10.39-3.32-17.43c-.1-6.75-.21-13.72-2.73-19.82-2.63-6.35-7.59-11.52-12.38-16.52S32,132,32,128s4.92-9.14,9.69-14.11,9.75-10.17,12.38-16.52c2.52-6.1,2.63-13.07,2.73-19.82.1-7,.21-14.33,3.32-17.43S70.51,56.9,77.55,56.8c6.75-.1,13.72-.21,19.82-2.73,6.35-2.63,11.52-7.59,16.52-12.38S124,32,128,32s9.15,4.92,14.11,9.69,10.17,9.75,16.52,12.38c6.1,2.52,13.07,2.63,19.82,2.73,7,.1,14.33.21,17.43,3.32s3.22,10.39,3.32,17.43c.1,6.75.21,13.72,2.73,19.82,2.63,6.35,7.59,11.52,12.38,16.52S224,124,224,128,219.08,137.14,214.31,142.11ZM120,96a24,24,0,1,0-24,24A24,24,0,0,0,120,96ZM88,96a8,8,0,1,1,8,8A8,8,0,0,1,88,96Zm72,40a24,24,0,1,0,24,24A24,24,0,0,0,160,136Zm0,32a8,8,0,1,1,8-8A8,8,0,0,1,160,168Zm13.66-74.34-80,80a8,8,0,0,1-11.32-11.32l80-80a8,8,0,0,1,11.32,11.32Z">
                                    </path>
                                </svg>
                                {{ $driver->default_percentage }}%
                            </a>
                        </li>
                        <li class="nav-item m-1" id="protab2">
                            <a href="javascript:void(0)" class="pe-none text-primary fw-medium nav-link" tabindex="-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm40-68a28,28,0,0,1-28,28h-4v8a8,8,0,0,1-16,0v-8H104a8,8,0,0,1,0-16h36a12,12,0,0,0,0-24H116a28,28,0,0,1,0-56h4V72a8,8,0,0,1,16,0v8h16a8,8,0,0,1,0,16H116a12,12,0,0,0,0,24h24A28,28,0,0,1,168,148Z">
                                    </path>
                                </svg>
                                {{ $driver->default_rental_price }}$
                            </a>
                        </li>
                        <li class="nav-item m-1" id="protab2">
                            <a href="javascript:void(0)" class="pe-none text-primary fw-medium nav-link" tabindex="-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000"
                                    viewBox="0 0 256 256">
                                    <path
                                        d="M221.35,104.11a8,8,0,0,0-6.57,9.21A88.85,88.85,0,0,1,216,128a87.62,87.62,0,0,1-22.24,58.41,79.66,79.66,0,0,0-36.06-28.75,48,48,0,1,0-59.4,0,79.66,79.66,0,0,0-36.06,28.75A88,88,0,0,1,128,40a88.76,88.76,0,0,1,14.68,1.22,8,8,0,0,0,2.64-15.78,103.92,103.92,0,1,0,85.24,85.24A8,8,0,0,0,221.35,104.11ZM96,120a32,32,0,1,1,32,32A32,32,0,0,1,96,120ZM74.08,197.5a64,64,0,0,1,107.84,0,87.83,87.83,0,0,1-107.84,0ZM237.66,45.66l-32,32a8,8,0,0,1-11.32,0l-16-16a8,8,0,0,1,11.32-11.32L200,60.69l26.34-26.35a8,8,0,0,1,11.32,11.32Z">
                                    </path>
                                </svg>
                                {{ $driver->addedBy?->full_name ?? 'N/A' }} - {{ $driver->created_at }}
                            </a>
                        </li>

                    </ul>
                    </p>


                </div>
            </div>
            <div class="card custom-card">
                <div class="card-body">
                    <ul class="nav nav-tabs flex-column nav-tabs-header mb-0 mail-sesttings-tab" role="tablist">
                        <li class="nav-item m-1">
                            <a class="nav-link active" data-bs-toggle="tab" role="tab" aria-current="page"
                                href="#personal-info" aria-selected="true">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                    <rect width="256" height="256" fill="none" />
                                    <path
                                        d="M216,48H40a8,8,0,0,0-8,8V200a8,8,0,0,0,8,8H216a8,8,0,0,0,8-8V56A8,8,0,0,0,216,48ZM96,144a24,24,0,1,1,24-24A24,24,0,0,1,96,144Z"
                                        opacity="0.2" />
                                    <line x1="152" y1="112" x2="192" y2="112" fill="none"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="16" />
                                    <line x1="152" y1="144" x2="192" y2="144" fill="none"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="16" />
                                    <rect x="32" y="48" width="192" height="160" rx="8" fill="none"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="16" />
                                    <circle cx="96" cy="120" r="24" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                    <path d="M64,168c3.55-13.8,17.09-24,32-24s28.46,10.19,32,24" fill="none"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="16" />
                                </svg>
                                Personal Information</a>
                        </li>
                        <li class="nav-item m-1">
                            <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page"
                                href="#account-settings" aria-selected="true">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                    <rect width="256" height="256" fill="none" />
                                    <path
                                        d="M207.86,123.18l16.78-21a99.14,99.14,0,0,0-10.07-24.29l-26.7-3a81,81,0,0,0-6.81-6.81l-3-26.71a99.43,99.43,0,0,0-24.3-10l-21,16.77a81.59,81.59,0,0,0-9.64,0l-21-16.78A99.14,99.14,0,0,0,77.91,41.43l-3,26.7a81,81,0,0,0-6.81,6.81l-26.71,3a99.43,99.43,0,0,0-10,24.3l16.77,21a81.59,81.59,0,0,0,0,9.64l-16.78,21a99.14,99.14,0,0,0,10.07,24.29l26.7,3a81,81,0,0,0,6.81,6.81l3,26.71a99.43,99.43,0,0,0,24.3,10l21-16.77a81.59,81.59,0,0,0,9.64,0l21,16.78a99.14,99.14,0,0,0,24.29-10.07l3-26.7a81,81,0,0,0,6.81-6.81l26.71-3a99.43,99.43,0,0,0,10-24.3l-16.77-21A81.59,81.59,0,0,0,207.86,123.18ZM128,168a40,40,0,1,1,40-40A40,40,0,0,1,128,168Z"
                                        opacity="0.2" />
                                    <circle cx="128" cy="128" r="40" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                    <path
                                        d="M41.43,178.09A99.14,99.14,0,0,1,31.36,153.8l16.78-21a81.59,81.59,0,0,1,0-9.64l-16.77-21a99.43,99.43,0,0,1,10.05-24.3l26.71-3a81,81,0,0,1,6.81-6.81l3-26.7A99.14,99.14,0,0,1,102.2,31.36l21,16.78a81.59,81.59,0,0,1,9.64,0l21-16.77a99.43,99.43,0,0,1,24.3,10.05l3,26.71a81,81,0,0,1,6.81,6.81l26.7,3a99.14,99.14,0,0,1,10.07,24.29l-16.78,21a81.59,81.59,0,0,1,0,9.64l16.77,21a99.43,99.43,0,0,1-10,24.3l-26.71,3a81,81,0,0,1-6.81,6.81l-3,26.7a99.14,99.14,0,0,1-24.29,10.07l-21-16.78a81.59,81.59,0,0,1-9.64,0l-21,16.77a99.43,99.43,0,0,1-24.3-10l-3-26.71a81,81,0,0,1-6.81-6.81Z"
                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="16" />
                                </svg>
                                Account Settings</a>
                        </li>
                        <li class="nav-item m-1">
                            <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page"
                                href="#email-settings" aria-selected="true">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                    <rect width="256" height="256" fill="none" />
                                    <polygon points="224 56 128 144 32 56 224 56" opacity="0.2" />
                                    <path
                                        d="M32,56H224a0,0,0,0,1,0,0V192a8,8,0,0,1-8,8H40a8,8,0,0,1-8-8V56A0,0,0,0,1,32,56Z"
                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="16" />
                                    <polyline points="224 56 128 144 32 56" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                </svg>
                                Email</a>
                        </li>
                        <li class="nav-item m-1">
                            <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page" href="#labels"
                                aria-selected="true">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                    <rect width="256" height="256" fill="none" />
                                    <path
                                        d="M42.34,138.34A8,8,0,0,1,40,132.69V40h92.69a8,8,0,0,1,5.65,2.34l99.32,99.32a8,8,0,0,1,0,11.31L153,237.66a8,8,0,0,1-11.31,0Z"
                                        opacity="0.2" />
                                    <path
                                        d="M42.34,138.34A8,8,0,0,1,40,132.69V40h92.69a8,8,0,0,1,5.65,2.34l99.32,99.32a8,8,0,0,1,0,11.31L153,237.66a8,8,0,0,1-11.31,0Z"
                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="16" />
                                    <circle cx="84" cy="84" r="12" />
                                </svg>
                                Labels</a>
                        </li>
                        <li class="nav-item m-1">
                            <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page"
                                href="#notification-settings" aria-selected="true">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                    <rect width="256" height="256" fill="none" />
                                    <path
                                        d="M56,104a72,72,0,0,1,144,0c0,35.82,8.3,64.6,14.9,76A8,8,0,0,1,208,192H48a8,8,0,0,1-6.88-12C47.71,168.6,56,139.81,56,104Z"
                                        opacity="0.2" />
                                    <path d="M96,192a32,32,0,0,0,64,0" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                    <path
                                        d="M56,104a72,72,0,0,1,144,0c0,35.82,8.3,64.6,14.9,76A8,8,0,0,1,208,192H48a8,8,0,0,1-6.88-12C47.71,168.6,56,139.81,56,104Z"
                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="16" />
                                </svg>
                                Notifications</a>
                        </li>
                        <li class="nav-item m-1">
                            <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page"
                                href="#security" aria-selected="true">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                    <rect width="256" height="256" fill="none" />
                                    <rect x="40" y="88" width="176" height="128" rx="8" opacity="0.2" />
                                    <rect x="40" y="88" width="176" height="128" rx="8" fill="none"
                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="16" />
                                    <circle cx="128" cy="152" r="12" />
                                    <path d="M88,88V56a40,40,0,0,1,80,0V88" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                </svg>
                                Security</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-9">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show active p-0 border-0" id="personal-info" role="tabpanel">
                            <div>
                                <h6 class="fw-medium mb-3">
                                    Profile :
                                </h6>
                                <div class="row gy-4 mb-4">
                                    <div class="col-xl-6">
                                        <label for="first-name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first-name"
                                            placeholder="First Name">
                                    </div>
                                    <div class="col-xl-6">
                                        <label for="last-name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last-name"
                                            placeholder="Last Name">
                                    </div>
                                    <div class="col-xl-12">
                                        <label class="form-label">User Name</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon3">user2413@gmail.com</span>
                                            <input type="text" class="form-control" id="basic-url"
                                                aria-describedby="basic-addon3">
                                        </div>
                                    </div>
                                </div>
                                <h6 class="fw-medium mb-3">
                                    Personal information :
                                </h6>
                                <div class="row gy-4">
                                    <div class="col-xl-6">
                                        <label for="email-address" class="form-label">Email Address :</label>
                                        <input type="text" class="form-control" id="email-address"
                                            placeholder="xyz@gmail.com">
                                    </div>
                                    <div class="col-xl-6">
                                        <label for="phone-no" class="form-label">Phone No :</label>
                                        <input type="text" class="form-control" id="phone-no"
                                            placeholder="Enter Phone No">
                                    </div>
                                    <div class="col-xl-6">
                                        <label for="language" class="form-label">Language :</label>
                                        <select class="form-control" name="language" id="language" multiple>
                                            <option value="Choice 1" selected>English</option>
                                            <option value="Choice 2">French</option>
                                            <option value="Choice 3">Arabic</option>
                                            <option value="Choice 4">Hindi</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-6">
                                        <label class="form-label">Country :</label>
                                        <select class="form-control" data-trigger name="country-select"
                                            id="country-select">
                                            <option value="Choice 1">Usa</option>
                                            <option value="Choice 2">Australia</option>
                                            <option value="Choice 3">Dubai</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-12">
                                        <label for="bio" class="form-label">Bio :</label>
                                        <textarea class="form-control" id="bio" rows="5">Lorem ipsum dolor sit amet consectetur adipisicing elit. At sit impedit, officiis non minima saepe voluptates a magnam enim sequi porro veniam ea suscipit dolorum vel mollitia voluptate iste nemo!</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane border-0 p-0" id="account-settings" role="tabpanel">
                            <div class="row gy-3">
                                <div class="col-xxl-7">
                                    <div class="card custom-card shadow-none mb-0 border">
                                        <div class="card-body">
                                            <div class="d-sm-flex d-block align-items-top mb-4 justify-content-between">
                                                <div class="w-75">
                                                    <p class="fs-14 mb-1 fw-medium">Two Step Verification</p>
                                                    <p class="fs-13 text-muted mb-0">Two step verificatoin is very secured
                                                        and restricts in happening faulty practices.</p>
                                                </div>
                                                <div class="toggle toggle-primary on mb-0" id="two-step-verification">
                                                    <span></span>
                                                </div>
                                            </div>
                                            <div class="d-sm-flex d-block align-items-top mb-4 justify-content-between">
                                                <div class="mb-sm-0 mb-2 w-75">
                                                    <p class="fs-14 mb-2 fw-medium">Authentication</p>
                                                    <div class="mb-0 authentication-btn-group">
                                                        <div class="btn-group" role="group"
                                                            aria-label="Basic radio toggle button group">
                                                            <input type="radio" class="btn-check" name="btnradio"
                                                                id="btnradio1" checked="">
                                                            <label class="btn btn-outline-light" for="btnradio1"><i
                                                                    class="ri-lock-unlock-line me-2 d-inline-block"></i>Pin</label>
                                                            <input type="radio" class="btn-check" name="btnradio"
                                                                id="btnradio2">
                                                            <label class="btn btn-outline-light" for="btnradio2"><i
                                                                    class="ri-lock-password-line me-2 d-inline-block"></i>Password</label>
                                                            <input type="radio" class="btn-check" name="btnradio"
                                                                id="btnradio3">
                                                            <label class="btn btn-outline-light" for="btnradio3"><i
                                                                    class="ri-fingerprint-line me-2 d-inline-block"></i>Finger
                                                                Print</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="toggle toggle-primary on mb-0 ms-0 mt-sm-0 mt-2"
                                                    id="authentication">
                                                    <span></span>
                                                </div>
                                            </div>
                                            <div class="d-sm-flex d-block align-items-top mb-4 justify-content-between">
                                                <div class="w-75">
                                                    <p class="fs-14 mb-1 fw-medium">Recovery Mail</p>
                                                    <p class="fs-13 text-muted mb-0">Incase of forgetting password mails
                                                        are sent to heifo@gmail.com</p>
                                                </div>
                                                <div class="toggle toggle-primary on mb-0 ms-0 mt-sm-0 mt-2"
                                                    id="recovery-mail">
                                                    <span></span>
                                                </div>
                                            </div>
                                            <div class="d-sm-flex d-block align-items-top mb-4 justify-content-between">
                                                <div>
                                                    <p class="fs-14 mb-1 fw-medium">SMS Recovery</p>
                                                    <p class="fs-13 text-muted mb-0">SMS are sent to 9102312xx in case of
                                                        recovery</p>
                                                </div>
                                                <div class="toggle toggle-primary on mb-0 ms-0 mt-sm-0 mt-2"
                                                    id="sms-recovery">
                                                    <span></span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-top justify-content-between">
                                                <div>
                                                    <p class="fs-14 mb-1 fw-medium">Reset Password</p>
                                                    <p class="fs-13 text-muted">Password should be min of <b
                                                            class="text-success">8 digits<sup>*</sup></b>,atleast <b
                                                            class="text-success">One Capital letter<sup>*</sup></b> and <b
                                                            class="text-success">One Special Character<sup>*</sup></b>
                                                        included.</p>
                                                    <div class="mb-2">
                                                        <label for="current-password" class="form-label">Current
                                                            Password</label>
                                                        <input type="text" class="form-control" id="current-password"
                                                            placeholder="Current Password">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="new-password" class="form-label">New Password</label>
                                                        <input type="text" class="form-control" id="new-password"
                                                            placeholder="New Password">
                                                    </div>
                                                    <div class="mb-0">
                                                        <label for="confirm-password" class="form-label">Confirm
                                                            Password</label>
                                                        <input type="text" class="form-control" id="confirm-password"
                                                            placeholder="Confirm Password">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-5">
                                    <div class="card custom-card shadow-none mb-0 border">
                                        <div class="card-header justify-content-between d-sm-flex d-block">
                                            <div class="card-title">Registered Devices</div>
                                            <div class="mt-sm-0 mt-2">
                                                <button class="btn btn-sm btn-primary">Signout from all devices</button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <div class="d-sm-flex d-block align-items-top">
                                                        <div class="lh-1 mb-sm-0 mb-2"><i
                                                                class="bi bi-phone me-3 fs-16 align-middle text-muted"></i>
                                                        </div>
                                                        <div class="lh-1 flex-fill">
                                                            <p class="mb-1">
                                                                <span class="fw-medium">Mobile-LG-1023</span>
                                                            </p>
                                                            <p class="mb-0">
                                                                <span class="text-muted fs-13">Manchester, UK-Nov 30,
                                                                    04:45PM</span>
                                                            </p>
                                                        </div>
                                                        <div class="dropdown mt-sm-0 mt-2">
                                                            <a href="javascript:void(0);"
                                                                class="btn btn-icon btn-sm btn-light"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fe fe-more-vertical"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item"
                                                                        href="javascript:void(0);">Action</a></li>
                                                                <li><a class="dropdown-item"
                                                                        href="javascript:void(0);">Another action</a></li>
                                                                <li><a class="dropdown-item"
                                                                        href="javascript:void(0);">Something else here</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-sm-flex d-block align-items-top">
                                                        <div class="lh-1 mb-sm-0 mb-2"><i
                                                                class="bi bi-laptop me-3 fs-16 align-middle text-muted"></i>
                                                        </div>
                                                        <div class="lh-1 flex-fill">
                                                            <p class="mb-1">
                                                                <span class="fw-medium">Lenovo-1291203</span>
                                                            </p>
                                                            <p class="mb-0">
                                                                <span class="text-muted fs-13">England, UK-Aug 12,
                                                                    12:25PM</span>
                                                            </p>
                                                        </div>
                                                        <div class="dropdown mt-sm-0 mt-2">
                                                            <a href="javascript:void(0);"
                                                                class="btn btn-icon btn-sm btn-light"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fe fe-more-vertical"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item"
                                                                        href="javascript:void(0);">Action</a></li>
                                                                <li><a class="dropdown-item"
                                                                        href="javascript:void(0);">Another action</a></li>
                                                                <li><a class="dropdown-item"
                                                                        href="javascript:void(0);">Something else here</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-sm-flex d-block align-items-top">
                                                        <div class="lh-1 mb-sm-0 mb-2"><i
                                                                class="bi bi-laptop me-3 fs-16 align-middle text-muted"></i>
                                                        </div>
                                                        <div class="lh-1 flex-fill">
                                                            <p class="mb-1">
                                                                <span class="fw-medium">Macbook-Suzika</span>
                                                            </p>
                                                            <p class="mb-0">
                                                                <span class="text-muted fs-13">Brightoon, UK-Jul 18,
                                                                    8:34AM</span>
                                                            </p>
                                                        </div>
                                                        <div class="dropdown mt-sm-0 mt-2">
                                                            <a href="javascript:void(0);"
                                                                class="btn btn-icon btn-sm btn-light"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fe fe-more-vertical"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item"
                                                                        href="javascript:void(0);">Action</a></li>
                                                                <li><a class="dropdown-item"
                                                                        href="javascript:void(0);">Another action</a></li>
                                                                <li><a class="dropdown-item"
                                                                        href="javascript:void(0);">Something else here</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="d-sm-flex d-block align-items-top">
                                                        <div class="lh-1 mb-sm-0 mb-2"><i
                                                                class="bi bi-pc-display-horizontal me-3 fs-16 align-middle text-muted"></i>
                                                        </div>
                                                        <div class="lh-1 flex-fill">
                                                            <p class="mb-1">
                                                                <span class="fw-medium">Apple-Desktop</span>
                                                            </p>
                                                            <p class="mb-0">
                                                                <span class="text-muted fs-13">Darlington, UK-Jan 14,
                                                                    11:14AM</span>
                                                            </p>
                                                        </div>
                                                        <div class="dropdown mt-sm-0 mt-2">
                                                            <a href="javascript:void(0);"
                                                                class="btn btn-icon btn-sm btn-light"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="fe fe-more-vertical"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item"
                                                                        href="javascript:void(0);">Action</a></li>
                                                                <li><a class="dropdown-item"
                                                                        href="javascript:void(0);">Another action</a></li>
                                                                <li><a class="dropdown-item"
                                                                        href="javascript:void(0);">Something else here</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane p-0" id="email-settings" role="tabpanel">
                            <ul class="list-group list-group-flush rounded">
                                <li class="list-group-item">
                                    <div class="row gy-2 d-sm-flex align-items-center justify-content-between">
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
                                            <span class="fs-14 fw-medium mb-0">Menu View :</span>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                    id="flexRadioDefault1">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Default View
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault"
                                                    id="flexRadioDefault2" checked="">
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    Advanced View
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="toggle toggle-danger on mb-0 float-sm-end" id="menu-view">
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row gy-3 d-sm-flex align-items-center justify-content-between">
                                        <div class="col-xl-3">
                                            <span class="fs-14 fw-medium mb-0">Language :</span>
                                        </div>
                                        <div class="col-xl-4">
                                            <label for="mail-language" class="form-label">Languages :</label>
                                            <select class="form-control" name="mail-language" id="mail-language"
                                                multiple>
                                                <option value="Choice 1" selected>English</option>
                                                <option value="Choice 2" selected>French</option>
                                                <option value="Choice 3">Arabic</option>
                                                <option value="Choice 4">Hindi</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="toggle toggle-success mb-0 float-sm-end" id="mail-languages">
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row gy-2 d-sm-flex align-items-center justify-content-between">
                                        <div class="col-xl-3">
                                            <span class="fs-14 fw-medium mb-0">Images :</span>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="images-open"
                                                    id="images-open1">
                                                <label class="form-check-label" for="images-open1">
                                                    Always Open Images
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="images-open"
                                                    id="images-hide2" checked="">
                                                <label class="form-check-label" for="images-hide2">
                                                    Ask For Permission
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="toggle toggle-success mb-0 float-sm-end" id="mails-images">
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row gy-2 d-sm-flex align-items-center justify-content-between">
                                        <div class="col-xl-3">
                                            <span class="fs-14 fw-medium mb-0">Keyboard Shortcuts :</span>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="keyboard-enable"
                                                    id="keyboard-enable1">
                                                <label class="form-check-label" for="keyboard-enable1">
                                                    Keyboard Shortcuts Enable
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="keyboard-enable"
                                                    id="keyboard-disable2" checked="">
                                                <label class="form-check-label" for="keyboard-disable2">
                                                    Keyboard Shortcuts Disable
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="toggle toggle-success mb-0 float-sm-end" id="keyboard-shortcuts">
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row gy-2 d-sm-flex align-items-center justify-content-between">
                                        <div class="col-xl-3">
                                            <span class="fs-14 fw-medium mb-0">Notifications :</span>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="desktop-notifications" checked="">
                                                <label class="form-check-label" for="desktop-notifications">
                                                    Desktop Notifications
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="mobile-notifications">
                                                <label class="form-check-label" for="mobile-notifications">
                                                    Mobile Notifications
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="float-sm-end">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-success-ghost btn-sm">Learn-more</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row gy-3 d-sm-flex align-items-center justify-content-between">
                                        <div class="col-xl-3">
                                            <span class="fs-14 fw-medium mb-0">Maximum Mails Per Page :</span>
                                        </div>
                                        <div class="col-xl-4">
                                            <select class="form-control" data-trigger name="mail-per-page"
                                                id="mail-per-page">
                                                <option value="Choice 1" selected>10</option>
                                                <option value="Choice 2">50</option>
                                                <option value="Choice 3">100</option>
                                                <option value="Choice 3">120</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="toggle toggle-success mb-0 float-sm-end" id="mails-per-page">
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row gy-2 d-sm-flex align-items-center justify-content-between">
                                        <div class="col-xl-3">
                                            <span class="fs-14 fw-medium mb-0">Mail Composer :</span>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="mail-composer"
                                                    id="mail-composeron1">
                                                <label class="form-check-label" for="mail-composeron1">
                                                    Mail Composer On
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="mail-composer"
                                                    id="mail-composeroff2" checked="">
                                                <label class="form-check-label" for="mail-composeroff2">
                                                    Mail Composer Off
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="toggle toggle-success mb-0 float-sm-end" id="mail-composer">
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row gy-2 d-sm-flex align-items-center justify-content-between">
                                        <div class="col-xl-3">
                                            <span class="fs-14 fw-medium mb-0">Auto Correct :</span>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="auto-correct"
                                                    id="auto-correcton1">
                                                <label class="form-check-label" for="auto-correcton1">
                                                    Auto Correct On
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="auto-correct"
                                                    id="auto-correctoff2" checked="">
                                                <label class="form-check-label" for="auto-correctoff2">
                                                    Auto Correct Off
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="toggle toggle-success mb-0 float-sm-end" id="auto-correct">
                                                <span></span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row gy-2 d-sm-flex align-items-center justify-content-between">
                                        <div class="col-xl-3">
                                            <span class="fs-14 fw-medium mb-0">Mail Send Action :</span>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="on-keyboard" checked="">
                                                <label class="form-check-label" for="on-keyboard">
                                                    On Keyboard Action
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="on-buttonclick">
                                                <label class="form-check-label" for="on-buttonclick">
                                                    On Button Click
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="float-sm-end">
                                                <a href="javascript:void(0)"
                                                    class="btn btn-success-ghost btn-sm">Learn-more</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="labels" role="tabpanel">
                            <p class="fs-14 fw-medium mb-3">Mail Labels :</p>
                            <div class="row gy-2">
                                <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="card custom-card shadow-none">
                                        <div
                                            class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <label class="form-check-label" for="label-all-mails">All Mails</label>
                                            <div class="form-check form-check-md form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="label-all-mails" checked="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="card custom-card shadow-none">
                                        <div
                                            class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <label class="form-check-label" for="label-sent">Inbox</label>
                                            <div class="form-check form-check-md form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="label-sent" checked="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="card custom-card shadow-none">
                                        <div
                                            class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <label class="form-check-label" for="label-sent2">Sent</label>
                                            <div class="form-check form-check-md form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="label-sent2" checked="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="card custom-card shadow-none">
                                        <div
                                            class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <label clas s="form-check-label" for="label-drafts">Drafts</label>
                                            <div class="form-check form-check-md form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="label-drafts" checked="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="card custom-card shadow-none">
                                        <div
                                            class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <label class="form-check-label" for="label-spam">Spam</label>
                                            <div class="form-check form-check-md form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="label-spam" checked="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="card custom-card shadow-none">
                                        <div
                                            class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <label class="form-check-label" for="label-important">Important</label>
                                            <div class="form-check form-check-md form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="label-important" checked="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="card custom-card shadow-none">
                                        <div
                                            class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <div class="form-check form-check-md form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="label-trash" checked="">
                                                <label class="form-check-label" for="label-trash">Trash</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="card custom-card shadow-none">
                                        <div
                                            class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <label class="form-check-label" for="label-archive">Archive</label>
                                            <div class="form-check form-check-md form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="label-archive" checked="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="card custom-card shadow-none">
                                        <div
                                            class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <label class="form-check-label" for="label-starred">Starred</label>
                                            <div class="form-check form-check-md form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="label-starred" checked="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="fs-14 fw-medium mb-3">Settings :</p>
                            <div class="row gy-2">
                                <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="card custom-card shadow-none">
                                        <div
                                            class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <label class="form-check-label" for="label-settings">Settings</label>
                                            <div class="form-check form-check-md form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="label-settings" checked="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="fs-14 fw-medium mb-3">Custom Labels :</p>
                            <div class="row gy-2">
                                <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="card custom-card shadow-none">
                                        <div
                                            class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <label class="form-check-label" for="label-mail">Mail</label>
                                            <div class="form-check form-check-md form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="label-mail" checked="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="card custom-card shadow-none">
                                        <div
                                            class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <label class="form-check-label" for="label-home">Home</label>
                                            <div class="form-check form-check-md form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="label-home" checked="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="card custom-card shadow-none">
                                        <div
                                            class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <label class="form-check-label" for="label-work">Work</label>
                                            <div class="form-check form-check-md form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="label-work" checked="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="card custom-card shadow-none">
                                        <div
                                            class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                                            <label class="form-check-label" for="label-friends">Friends</label>
                                            <div class="form-check form-check-md form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="label-friends" checked="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane p-0" id="notification-settings" role="tabpanel">
                            <ul class="list-group list-group-flush list-unstyled rounded">
                                <li class="list-group-item">
                                    <div class="row gx-5 gy-3">
                                        <div class="col-xl-5">
                                            <p class="fs-16 mb-1 fw-medium">Email Notifications</p>
                                            <p class="fs-13 mb-0 text-muted">Email notifications are the notifications you
                                                will receeive when you are offline, you can customize them by enabling or
                                                disabling them.</p>
                                        </div>
                                        <div class="col-xl-7">
                                            <div class="d-flex align-items-top justify-content-between mt-sm-0 mt-3">
                                                <div class="mail-notification-settings">
                                                    <p class="fs-14 mb-1 fw-medium">Updates & Features</p>
                                                    <p class="fs-13 mb-0 text-muted">Notifications about new updates and
                                                        their features.</p>
                                                </div>
                                                <div class="toggle toggle-success on mb-0 float-sm-end"
                                                    id="update-features">
                                                    <span></span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-top justify-content-between mt-3">
                                                <div class="mail-notification-settings">
                                                    <p class="fs-14 mb-1 fw-medium">Early Access</p>
                                                    <p class="fs-13 mb-0 text-muted">Users are selected for beta testing
                                                        of
                                                        new update,notifications relating or participate in any of paid
                                                        product promotion.</p>
                                                </div>
                                                <div class="toggle toggle-success mb-0 float-sm-end" id="early-access">
                                                    <span></span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-top justify-content-between mt-3">
                                                <div class="mail-notification-settings">
                                                    <p class="fs-14 mb-1 fw-medium">Email Shortcuts</p>
                                                    <p class="fs-13 mb-0 text-muted">Shortcut notifications for email.</p>
                                                </div>
                                                <div class="toggle toggle-success on mb-0 float-sm-end"
                                                    id="email-shortcut">
                                                    <span></span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-top justify-content-between mt-3">
                                                <div class="mail-notification-settings">
                                                    <p class="fs-14 mb-1 fw-medium">New Mails</p>
                                                    <p class="fs-13 mb-0 text-muted">Notifications related to new mails
                                                        received.</p>
                                                </div>
                                                <div class="toggle toggle-success on mb-0 float-sm-end" id="new-mails">
                                                    <span></span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-top justify-content-between mt-3">
                                                <div class="mail-notification-settings">
                                                    <p class="fs-14 mb-1 fw-medium">Mail Chat Messages</p>
                                                    <p class="fs-13 mb-0 text-muted">Any of new messages are received will
                                                        be updated through notifications.</p>
                                                </div>
                                                <div class="toggle toggle-success on mb-0 float-sm-end"
                                                    id="mail-chat-messages">
                                                    <span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row gx-5 gy-3">
                                        <div class="col-xl-5">
                                            <p class="fs-16 mb-1 fw-medium">Push Notifications</p>
                                            <p class="fs-13 mb-0 text-muted">Push notifications are recieved when you are
                                                online, you can customize them by enabling or disabling them.</p>
                                        </div>
                                        <div class="col-xl-7">
                                            <div class="d-flex align-items-top justify-content-between mt-sm-0 mt-3">
                                                <div class="mail-notification-settings">
                                                    <p class="fs-14 mb-1 fw-medium">New Mails</p>
                                                    <p class="fs-13 mb-0 text-muted">Notifications related to new mails
                                                        received.</p>
                                                </div>
                                                <div class="toggle toggle-success on mb-0 float-sm-end"
                                                    id="push-new-mails">
                                                    <span></span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-top justify-content-between mt-3">
                                                <div class="mail-notification-settings">
                                                    <p class="fs-14 mb-1 fw-medium">Mail Chat Messages</p>
                                                    <p class="fs-13 mb-0 text-muted">Any of new messages are received will
                                                        be updated through notifications.</p>
                                                </div>
                                                <div class="toggle toggle-success on mb-0 float-sm-end"
                                                    id="push-mail-chat-messages">
                                                    <span></span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-top justify-content-between mt-3">
                                                <div class="mail-notification-settings">
                                                    <p class="fs-14 mb-1 fw-medium">Mail Extensions</p>
                                                    <p class="fs-13 mb-0 text-muted">Notifications related to the
                                                        extensions received by new emails and thier propertied also been
                                                        displayed.</p>
                                                </div>
                                                <div class="toggle toggle-success mb-0 float-sm-end" id="mail-extensions">
                                                    <span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane p-0" id="security" role="tabpanel">
                            <ul class="list-group list-group-flush list-unstyled rounded">
                                <li class="list-group-item">
                                    <div class="row gx-5 gy-3">
                                        <div class="col-xl-4">
                                            <p class="fs-16 mb-1 fw-medium">Logging In</p>
                                            <p class="fs-13 mb-0 text-muted">Security settings related to logging into our
                                                email account and taking down account if any mischevious action happended.
                                            </p>
                                        </div>
                                        <div class="col-xl-8">
                                            <div
                                                class="d-sm-flex d-block align-items-top justify-content-between mt-sm-0 mt-3">
                                                <div class="mail-security-settings">
                                                    <p class="fs-14 mb-1 fw-medium">Max Limit for login attempts</p>
                                                    <p class="fs-13 mb-0 text-muted mb-sm-0 mb-2">Account will freeze for
                                                        24hrs while attempt to login with wrong credentials for selected
                                                        number of times</p>
                                                </div>
                                                <div>
                                                    <select class="form-control" data-trigger name="max-login-attempts"
                                                        id="max-login-attempts">
                                                        <option value="Choice 1" selected>3 Attempts</option>
                                                        <option value="Choice 2">5 Attempts</option>
                                                        <option value="Choice 3">10 Attempts</option>
                                                        <option value="Choice 3">20 Attempts</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="d-sm-flex d-block align-items-top justify-content-between mt-3">
                                                <div>
                                                    <p class="fs-14 mb-1 fw-medium">Account Freeze time management</p>
                                                    <p class="fs-13 mb-0 text-muted mb-sm-0 mb-2">You can change the time
                                                        for the account freeze when attempts for </p>
                                                </div>
                                                <div>
                                                    <select class="form-control" data-trigger
                                                        name="account-freeze-time-format"
                                                        id="account-freeze-time-format">
                                                        <option value="Choice 1" selected>1 Day</option>
                                                        <option value="Choice 2">1 Hour</option>
                                                        <option value="Choice 3">1 Month</option>
                                                        <option value="Choice 3">1 Year</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row gx-5 gy-3">
                                        <div class="col-xl-4">
                                            <p class="fs-16 mb-1 fw-medium">Password Requirements</p>
                                            <p class="fs-13 mb-0 text-muted">Security settings related to password
                                                strength.</p>
                                        </div>
                                        <div class="col-xl-8">
                                            <div
                                                class="d-sm-flex d-block align-items-top justify-content-between mt-sm-0 mt-3 gap-3">
                                                <div class="mail-security-settings">
                                                    <p class="fs-14 mb-1 fw-medium">Minimum number of characters in the
                                                        password</p>
                                                    <p class="fs-13 mb-0 text-muted">There should be a minimum number of
                                                        characters for a password to be validated that shouls be set here.
                                                    </p>
                                                </div>
                                                <div>
                                                    <input type="text" class="form-control" value="8">
                                                </div>
                                            </div>
                                            <div class="d-sm-flex d-block align-items-top justify-content-between mt-3">
                                                <div>
                                                    <p class="fs-14 mb-1 fw-medium">Contain A Number</p>
                                                    <p class="fs-13 mb-0 text-muted">Password should contain a number.</p>
                                                </div>
                                                <div class="toggle toggle-success on mb-0 float-sm-end"
                                                    id="password-number">
                                                    <span></span>
                                                </div>
                                            </div>
                                            <div class="d-sm-flex d-block align-items-top justify-content-between mt-3">
                                                <div>
                                                    <p class="fs-14 mb-1 fw-medium">Contain A Special Character</p>
                                                    <p class="fs-13 mb-0 text-muted">Password should contain a special
                                                        Character.</p>
                                                </div>
                                                <div class="toggle toggle-success on mb-0 float-sm-end"
                                                    id="password-special-character">
                                                    <span></span>
                                                </div>
                                            </div>
                                            <div class="d-sm-flex d-block align-items-top justify-content-between mt-3">
                                                <div>
                                                    <p class="fs-14 mb-1 fw-medium">Atleast One Capital Letter</p>
                                                    <p class="fs-13 mb-0 text-muted">Password should contain atleast one
                                                        capital letter.</p>
                                                </div>
                                                <div class="toggle toggle-success mb-0 float-sm-end"
                                                    id="password-capital">
                                                    <span></span>
                                                </div>
                                            </div>
                                            <div class="d-sm-flex d-block align-items-top justify-content-between mt-3">
                                                <div>
                                                    <p class="fs-14 mb-1 fw-medium">Maximum Password Length</p>
                                                    <p class="fs-13 mb-0 text-muted">Maximum password lenth should be
                                                        selected here.</p>
                                                </div>
                                                <div>
                                                    <input type="text" class="form-control" value="16">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row gx-5 gy-3">
                                        <div class="col-xl-4">
                                            <p class="fs-16 mb-1 fw-medium">Unknown Chats</p>
                                            <p class="fs-13 mb-0 text-muted">Security settings related to unknown chats.
                                            </p>
                                        </div>
                                        <div class="col-xl-8">
                                            <div class="btn-group float-sm-end" role="group"
                                                aria-label="Basic radio toggle button group">
                                                <input type="radio" class="btn-check" name="btnunknownchats"
                                                    id="unknown-chats-show" checked="">
                                                <label class="btn btn-outline-light"
                                                    for="unknown-chats-show">Show</label>
                                                <input type="radio" class="btn-check" name="btnunknownchats"
                                                    id="unknown-chats-hide">
                                                <label class="btn btn-outline-light"
                                                    for="unknown-chats-hide">Hide</label>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-end">
                        <button class="btn btn-light m-1">
                            Restore Defaults
                        </button>
                        <button class="btn btn-primary m-1">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection


@section('scripts')
    <script>
        // SSN visibility toggle
        document.querySelectorAll('.ssn-value').forEach(function(element) {
            element.closest('a').addEventListener('click', function(e) {
                e.preventDefault();
                const ssnSpan = element;
                const toggleIcon = this.querySelector('.ssn-toggle-icon');
                const actualSSN = ssnSpan.dataset.ssn;
                const isMasked = ssnSpan.textContent.includes('*');

                if (isMasked) {
                    ssnSpan.textContent = actualSSN;
                    toggleIcon.style.opacity = '0.6';
                } else {
                    ssnSpan.textContent = '**********';
                    toggleIcon.style.opacity = '1';
                }
            });
        });
    </script>
@endsection
