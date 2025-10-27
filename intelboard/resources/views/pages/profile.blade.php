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
                    @if ($user->logo)
                        <div class="position-relative d-inline-block mb-3">
                            <img src="{{ asset($user->logo) }}"
                                 alt="{{ $user->company_name ?? $user->full_name }}"
                                 class="img-fluid"
                                 style="max-width: 100%; height: auto; border-radius: 8px; max-height: 200px; object-fit: contain;">
                            <span id="active"
                                  class="badge rounded-pill
                            @if ($user->active == '0') bg-danger @endif
                            @if ($user->active == '1') bg-success @endif"
                                  style="position: absolute; bottom: 10px; right: 10px;"></span>
                        </div>
                    @else
                        <span class="avatar avatar-xxl avatar-rounded bg-primary text-light">
                            <span class="avatar-text fw-bold fs-5"
                                  style="color: white !important;">{{ $initials }}</span>
                            <span id="active"
                                  class="badge rounded-pill
                            @if ($user->active == '0') bg-danger @endif
                            @if ($user->active == '1') bg-success @endif avatar-badge"></span>
                        </span>
                    @endif
                    <h6 class="fw-semibold mt-3 mb-1">{{ $user->full_name }}</h6>
                    @if ($user->company_name)
                        <span class="d-block fs-13 text-muted fw-medium mb-2">{{ $user->company_name }}</span>
                    @endif
                    <span class="d-block fs-13 text-muted">
                        {{ __('messages.subscription') }} :
                        {{ $user->legacySubscription?->subscriptionType?->name ?? 'None' }}
                    </span>
                    <span class="d-block fs-13 text-muted">
                        {{ __('messages.until') }} :
                        {{ $user->legacySubscription?->ends_at?->format('Y-m-d') ?? 'N/A' }}
                    </span>
                </div>
            </div>

            <div class="card custom-card">
                <div class="card-body">
                    <!-- removed tab navigation to use a single form view -->
                    @if($canAddSupervisor ?? false)
                        <a href="#" id="createSupervisorBtn" class="btn btn-md form-control btn-success">
                            <i class="ri-user-add-fill me-2 fs-5"></i>{{ __('messages.add_supervisor') }}
                        </a>
                    @else
                        <button type="button" class="btn btn-md form-control btn-secondary" disabled
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="{{ __('messages.add_supervisor_not_allowed') }}">
                            <i class="ri-user-add-fill me-2 fs-5"></i>{{ __('messages.add_supervisor') }}
                        </button>
                        <small class="text-muted d-block mt-2 text-center">
                            <i class="ri-information-line"></i> {{ __('messages.upgrade_to_add_supervisors') ?? 'Upgrade your plan to add supervisors' }}
                        </small>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content: Single combined form -->
        <div class="col-xl-9">
            <div class="card custom-card">
                <form method="POST" action="{{ route('profile.update') }}" id="profileForm"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="row gy-4 mb-4">
                            <div class="col-12">
                                <label for="full_name" class="form-label">{{ __('messages.full_name') }}</label>
                                <input type="text" name="full_name" id="full_name" class="form-control"
                                       placeholder="{{ __('messages.full_name') }}"
                                       value="{{ old('full_name', $user->full_name) }}">
                            </div>
                        </div>

                        <div class="row gy-4 mb-4">
                            <div class="col-xl-6">
                                <label for="email" class="form-label">{{ __('messages.login_email_label') }} :</label>
                                <input type="email" name="email" id="email" class="form-control"
                                       placeholder="{{ __('messages.login_email_label') }}"
                                       value="{{ old('email', $user->email) }}">
                            </div>
                            <div class="col-xl-6">
                                <label for="phone_number" class="form-label">{{ __('messages.phone_number') }} :</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control"
                                       placeholder="{{ __('messages.phone_number') }}"
                                       value="{{ old('phone_number', $user->phone_number) }}">
                            </div>
                        </div>

                        <div class="row gy-4 mb-4">
                            <div class="col-xl-6">
                                <label for="company_name"
                                       class="form-label">{{ __('messages.company_name') ?? 'Company name' }} :</label>
                                <input type="text" name="company_name" id="company_name" class="form-control"
                                       placeholder="{{ __('messages.company_name') ?? 'Company name' }}"
                                       value="{{ old('company_name', $user->company_name ?? '') }}">
                            </div>
                            <div class="col-xl-6">
                                <label for="logo" class="form-label">{{ __('messages.logo') ?? 'Logo' }} :</label>
                                <input type="file" name="logo" id="logo" class="form-control form-control-sm"
                                       accept="image/*">
                            </div>
                        </div>

                        <div class="row gy-4 mb-4">
                            <div class="col-xl-6">
                                <label for="language"
                                       class="form-label">{{ __('messages.language_preference') ?? 'Language Preference' }}
                                    :</label>
                                <select class="form-control" id="language" name="language" required>
                                    <option
                                        value="en" @selected((old('language', $preferences?->language ?? 'en')) === 'en')>{{ __('messages.language_en') }}</option>
                                    <option
                                        value="fr" @selected((old('language', $preferences?->language ?? 'en')) === 'fr')>{{ __('messages.language_fr') }}</option>
                                </select>
                            </div>

                            <div class="col-xl-6">
                                <label for="theme"
                                       class="form-label">{{ __('messages.theme_preference') ?? 'Theme Preference' }}
                                    :</label>
                                <select class="form-control" id="theme" name="theme" required>
                                    <option
                                        value="light" @selected((old('theme', $preferences?->theme ?? 'light')) === 'light')>{{ __('messages.light_theme') ?? 'Light' }}</option>
                                    <option
                                        value="dark" @selected((old('theme', $preferences?->theme ?? 'light')) === 'dark')>{{ __('messages.dark_theme') ?? 'Dark' }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row gy-4">
                            <div class="col-xl-6">
                                <label for="current_password" class="form-label">{{ __('messages.current_password') }}
                                    :</label>
                                <input type="password" name="current_password" id="current_password"
                                       class="form-control" placeholder="••••••••">
                            </div>
                            <div class="col-xl-6">
                                <label for="new_password" class="form-label">{{ __('messages.new_password') }} :</label>
                                <input type="password" name="new_password" id="new_password" class="form-control"
                                       placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer mb-4">
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
