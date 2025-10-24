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
        <!-- Sidebar -->
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
                            <a class="nav-link active" data-bs-toggle="tab" role="tab" href="#personal-info"
                                aria-selected="true">
                                <i class="ri-id-card-line fs-5"></i>
                                Personal Information
                            </a>
                        </li>
                        <li class="nav-item m-1">
                            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#account-preferences"
                                aria-selected="true">
                                <i class="ri-user-settings-line fs-5"></i>
                                Preferences
                            </a>
                        </li>
                        <li class="nav-item m-1">
                            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#company-settings"
                                aria-selected="true">
                                <i class="ri-equalizer-line fs-5"></i>
                                Company Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-xl-9">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="tab-content">

                        <!-- PERSONAL INFO TAB -->
                        <div class="tab-pane p-0 border-0" id="personal-info" role="tabpanel">
                            <form method="POST" action="{{ route('profile.update-preferences') }}" id="preferencesForm">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="row gy-4 mb-4">
                                        <div class="col-12">
                                            <label for="name" class="form-label">{{ __('messages.full_name') }}</label>
                                            <input type="text" class="form-control" id="name" disabled
                                                placeholder="{{ $user->full_name }}" value="{{ $user->full_name }}">
                                            <small class="text-muted">{{ __('messages.read_only') ?? 'Read only' }}</small>
                                        </div>
                                    </div>

                                    <div class="row gy-4 mb-4">
                                        <div class="col-xl-6">
                                            <label for="email-address"
                                                class="form-label">{{ __('messages.login_email_label') }} :</label>
                                            <input type="text" class="form-control" id="email-address" disabled
                                                placeholder="{{ $user->email }}" value="{{ $user->email }}">
                                            <small class="text-muted">{{ __('messages.read_only') ?? 'Read only' }}</small>
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="phone-no" class="form-label">{{ __('messages.phone_number') }}
                                                :</label>
                                            <input type="text" class="form-control" id="phone-no" disabled
                                                placeholder="{{ $user->phone_number }}" value="{{ $user->phone_number }}">
                                            <small class="text-muted">{{ __('messages.read_only') ?? 'Read only' }}</small>
                                        </div>
                                    </div>

                                    <div class="row gy-4 mb-4">
                                        <div class="col-xl-6">
                                            <label for="language-preference" class="form-label">
                                                {{ __('messages.language_preference') ?? 'Language Preference' }} :
                                            </label>
                                            <select class="form-control" id="language-preference" name="language" required>
                                                <option value="en" @selected(($preferences?->language ?? 'en') === 'en')>
                                                    {{ __('messages.language_en') }}
                                                </option>
                                                <option value="fr" @selected(($preferences?->language ?? 'en') === 'fr')>
                                                    {{ __('messages.language_fr') }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-xl-6">
                                            <label for="theme-preference" class="form-label">
                                                {{ __('messages.theme_preference') ?? 'Theme Preference' }} :
                                            </label>
                                            <select class="form-control" id="theme-preference" name="theme" required>
                                                <option value="light" @selected(($preferences?->theme ?? 'light') === 'light')>
                                                    {{ __('messages.light_theme') ?? 'Light' }}
                                                </option>
                                                <option value="dark" @selected(($preferences?->theme ?? 'light') === 'dark')>
                                                    {{ __('messages.dark_theme') ?? 'Dark' }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row gy-4">
                                        <div class="col-xl-6">
                                            <label for="password"
                                                class="form-label">{{ __('messages.current_password') }} :</label>
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

                        <!-- ACCOUNT SETTINGS TAB -->
                        <div class="tab-pane border-0 p-0" id="account-preferences" role="tabpanel">
                            <form method="POST" action="{{ route('profile.update-preferences') }}"
                                id="preferencesForm">
                                @csrf
                                @method('PUT')
                                <div class="card-body">


                                    <div class="row gy-4 mb-4">
                                        <div class="col-xl-6">
                                            <label for="language-preference" class="form-label">
                                                {{ __('messages.language_preference') ?? 'Language Preference' }} :
                                            </label>
                                            <select class="form-control" id="language-preference" name="language"
                                                required>
                                                <option value="en" @selected(($preferences?->language ?? 'en') === 'en')>
                                                    {{ __('messages.language_en') }}
                                                </option>
                                                <option value="fr" @selected(($preferences?->language ?? 'fr') === 'fr')>
                                                    {{ __('messages.language_fr') }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-xl-6">
                                            <label for="theme-preference" class="form-label">
                                                {{ __('messages.theme_preference') ?? 'Theme Preference' }} :
                                            </label>
                                            <select class="form-control" id="theme-preference" name="theme" required>
                                                <option value="light" @selected(($preferences?->theme ?? 'light') === 'light')>
                                                    {{ __('messages.light_theme') ?? 'Light' }}
                                                </option>
                                                <option value="dark" @selected(($preferences?->theme ?? 'light') === 'dark')>
                                                    {{ __('messages.dark_theme') ?? 'Dark' }}
                                                </option>
                                            </select>
                                        </div>
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

                        <!-- EMAIL SETTINGS TAB -->
                        <div class="tab-pane show active p-0 border-0" id="company-settings" role="tabpanel">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
