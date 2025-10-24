@extends('layouts.master')

@section('styles')
@endsection

@section('content')
    <!-- Profile Header -->
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.profile') }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('index') }}">{{ __('messages.dashboard_menu') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.profile') }}</li>
            </ol>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-xl-3">
            <div class="card custom-card">
                <div class="card-body text-center p-4">
                    @php
                        $nameParts = explode(' ', trim($user->full_name));
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
                            class="badge rounded-pill
                            @if ($user->active == '0') bg-danger @endif
                            @if ($user->active == '1') bg-success @endif avatar-badge"></span>
                    </span>
                    <h6 class="fw-semibold mt-3 mb-1">{{ $user->full_name }}</h6>
                    <span class="d-block fs-13 text-muted">
                        {{ __('messages.subscription') }} :
                        {{ $user->subscription?->subscriptionType?->name ?? 'None' }}
                    </span>
                    <span class="d-block fs-13 text-muted">
                        {{ __('messages.until') }} :
                        {{ $user->subscription?->ends_at?->format('Y-m-d') ?? 'N/A' }}
                    </span>
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
                                        fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="16" />
                                </svg>
                                Account Settings</a>
                        </li>
                        <!-- Other commented tabs remain here -->
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-9">
            <div class="card custom-card">
                <form method="PUT" action="{{ route('profile.update-preferences') }}" id="preferencesForm">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active p-0 border-0" id="personal-info" role="tabpanel">
                                <div>
                                    <div class="row gy-4 mb-4">
                                        <div class="col-12">
                                            <label for="name"
                                                class="form-label">{{ __('messages.full_name') }}</label>
                                            <input type="text" class="form-control" id="name" disabled
                                                placeholder="{{ $user->full_name }}" value="{{ $user->full_name }}">
                                            <small
                                                class="text-muted">{{ __('messages.read_only') ?? 'Read only' }}</small>
                                        </div>
                                    </div>
                                    <div class="row gy-4 mb-4">
                                        <div class="col-xl-6">
                                            <label for="email-address"
                                                class="form-label">{{ __('messages.login_email_label') }} :</label>
                                            <input type="text" class="form-control" id="email-address" disabled
                                                placeholder="{{ $user->email }}" value="{{ $user->email }}">
                                            <small
                                                class="text-muted">{{ __('messages.read_only') ?? 'Read only' }}</small>
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="phone-no" class="form-label">{{ __('messages.phone_number') }}
                                                :</label>
                                            <input type="text" class="form-control" id="phone-no" disabled
                                                placeholder="{{ $user->phone_number }}"
                                                value="{{ $user->phone_number }}">
                                            <small
                                                class="text-muted">{{ __('messages.read_only') ?? 'Read only' }}</small>
                                        </div>
                                    </div>
                                    <div class="row gy-4 mb-4">
                                        <div class="col-xl-6">
                                            <label for="language-preference"
                                                class="form-label">{{ __('messages.language_preference') ?? 'Language Preference' }}
                                                :</label>
                                            <select class="form-control" id="language-preference" name="language"
                                                required>
                                                <option value="en" @selected(($preferences?->language ?? 'en') === 'en')>
                                                    {{ __('messages.language_en') }}</option>
                                                <option value="fr" @selected(($preferences?->language ?? 'en') === 'fr')>
                                                    {{ __('messages.language_fr') }}</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="theme-preference"
                                                class="form-label">{{ __('messages.theme_preference') ?? 'Theme Preference' }}
                                                :</label>
                                            <select class="form-control" id="theme-preference" name="theme" required>
                                                <option value="light" @selected(($preferences?->theme ?? 'light') === 'light')>
                                                    {{ __('messages.light_theme') ?? 'Light' }}</option>
                                                <option value="dark" @selected(($preferences?->theme ?? 'light') === 'dark')>
                                                    {{ __('messages.dark_theme') ?? 'Dark' }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row gy-4">
                                        <div class="col-xl-6">
                                            <label for="password"
                                                class="form-label">{{ __('messages.current_password') }}
                                                :</label>
                                            <input type="password" class="form-control" id="password"
                                                placeholder="••••••••••••">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="newpassword" class="form-label">{{ __('messages.new_password') }}
                                                :</label>
                                            <input type="password" class="form-control" id="newpassword"
                                                placeholder="••••••••••••">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Other tabs remain commented --}}
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-end">
                            <button type="submit" class="btn btn-primary label-btn label-end">
                                {{ __('messages.save_changes') ?? 'Save changes' }}
                                <i class="ri-save-fill label-btn-icon ms-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
