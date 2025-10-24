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
        <!-- Left Sidebar with User Info and Tab Navigation -->
        <div class="col-xl-3">
            <!-- User Card -->
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

            <!-- Tab Navigation -->
            <div class="card custom-card">
                <div class="card-body">
                    <ul class="nav nav-tabs flex-column nav-tabs-header mb-0 mail-sesttings-tab" role="tablist">
                        <li class="nav-item m-1">
                            <a class="nav-link active" data-bs-toggle="tab" role="tab" aria-current="page"
                                href="#personal-info" aria-selected="true">
                                <i class="ri-id-card-line fs-5"></i>
                                Personal Information</a>
                        </li>
                        <li class="nav-item m-1">
                            <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page"
                                href="#account-settings" aria-selected="false">
                                <i class="ri-user-settings-line fs-5"></i>
                                Preferences</a>
                        </li>
                        <li class="nav-item m-1">
                            <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page"
                                href="#email-settings" aria-selected="false">
                                <i class="ri-equalizer-line fs-5"></i>
                                Company settings</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Right Content Area with Tab Panes -->
        <div class="col-xl-9">
            <div class="card custom-card">
                <div class="tab-content">
                    <!-- Personal Information Tab -->
                    <div class="tab-pane show active p-0 border-0" id="personal-info" role="tabpanel">
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
                                    <label for="email-address" class="form-label">{{ __('messages.login_email_label') }}
                                        :</label>
                                    <input type="text" class="form-control" id="email-address" disabled
                                        placeholder="{{ $user->email }}" value="{{ $user->email }}">
                                    <small class="text-muted">{{ __('messages.read_only') ?? 'Read only' }}</small>
                                </div>
                                <div class="col-xl-6">
                                    <label for="phone-no" class="form-label">{{ __('messages.phone_number') }} :</label>
                                    <input type="text" class="form-control" id="phone-no" disabled
                                        placeholder="{{ $user->phone_number }}" value="{{ $user->phone_number }}">
                                    <small class="text-muted">{{ __('messages.read_only') ?? 'Read only' }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preferences Tab -->
                    <div class="tab-pane border-0 p-0" id="account-settings" role="tabpanel">
                        <form method="PUT" action="{{ route('profile.update-preferences') }}" id="preferencesForm">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row gy-4 mb-4">
                                    <div class="col-xl-6">
                                        <label for="language-preference"
                                            class="form-label">{{ __('messages.language_preference') ?? 'Language Preference' }}
                                            :</label>
                                        <select class="form-control" id="language-preference" name="language" required>
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

                                <hr class="my-4">
                                <h6 class="fw-semibold mb-4">{{ __('messages.reset_password') ?? 'Change Password' }}</h6>

                                <div class="row gy-4">
                                    <div class="col-xl-6">
                                        <label for="password" class="form-label">{{ __('messages.current_password') }}
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

                    <!-- Company Settings Tab -->
                    <div class="tab-pane border-0 p-0" id="email-settings" role="tabpanel">
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
                                        <select class="form-control" name="mail-language" id="mail-language" multiple>
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
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-7">
        <div class="card custom-card shadow-none mb-0 border">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-top mb-4 justify-content-between">
                    <div class="w-75">
                        <p class="fs-14 mb-1 fw-medium">Two Step Verification
                        </p>
                        <p class="fs-13 text-muted mb-0">Two step verificatoin
                            is very
                            secured and restricts in happening faulty practices.
                        </p>
                    </div>
                    <div class="toggle toggle-primary on mb-0" id="two-step-verification">
                        <span></span>
                    </div>
                </div>
                <div class="d-sm-flex d-block align-items-top mb-4 justify-content-between">
                    <div class="mb-sm-0 mb-2 w-75">
                        <p class="fs-14 mb-2 fw-medium">Authentication</p>
                        <div class="mb-0 authentication-btn-group">
                            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio1" checked="">
                                <label class="btn btn-outline-light" for="btnradio1"><i
                                        class="ri-lock-unlock-line me-2 d-inline-block"></i>Pin</label>
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio2">
                                <label class="btn btn-outline-light" for="btnradio2"><i
                                        class="ri-lock-password-line me-2 d-inline-block"></i>Password</label>
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio3">
                                <label class="btn btn-outline-light" for="btnradio3"><i
                                        class="ri-fingerprint-line me-2 d-inline-block"></i>Finger
                                    Print</label>
                            </div>
                        </div>
                    </div>
                    <div class="toggle toggle-primary on mb-0 ms-0 mt-sm-0 mt-2" id="authentication">
                        <span></span>
                    </div>
                </div>
                <div class="d-sm-flex d-block align-items-top mb-4 justify-content-between">
                    <div class="w-75">
                        <p class="fs-14 mb-1 fw-medium">Recovery Mail</p>
                        <p class="fs-13 text-muted mb-0">Incase of forgetting
                            password
                            mails are sent to heifo@gmail.com</p>
                    </div>
                    <div class="toggle toggle-primary on mb-0 ms-0 mt-sm-0 mt-2" id="recovery-mail">
                        <span></span>
                    </div>
                </div>
                <div class="d-sm-flex d-block align-items-top mb-4 justify-content-between">
                    <div>
                        <p class="fs-14 mb-1 fw-medium">SMS Recovery</p>
                        <p class="fs-13 text-muted mb-0">SMS are sent to
                            9102312xx in case
                            of recovery</p>
                    </div>
                    <div class="toggle toggle-primary on mb-0 ms-0 mt-sm-0 mt-2" id="sms-recovery">
                        <span></span>
                    </div>
                </div>
                <div class="d-flex align-items-top justify-content-between">
                    <div>
                        <p class="fs-14 mb-1 fw-medium">Reset Password</p>
                        <p class="fs-13 text-muted">Password should be min of
                            <b class="text-success">8
                                digits<sup>*</sup></b>,atleast <b class="text-success">One Capital
                                letter<sup>*</sup></b> and
                            <b class="text-success">One Special
                                Character<sup>*</sup></b>
                            included.
                        </p>
                        <div class="mb-2">
                            <label for="current-password" class="form-label">Current
                                Password</label>
                            <input type="text" class="form-control" id="current-password"
                                placeholder="Current Password">
                        </div>
                        <div class="mb-2">
                            <label for="new-password" class="form-label">New
                                Password</label>
                            <input type="text" class="form-control" id="new-password" placeholder="New Password">
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
                    <button class="btn btn-sm btn-primary">Signout from all
                        devices</button>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <div class="d-sm-flex d-block align-items-top">
                            <div class="lh-1 mb-sm-0 mb-2"><i class="bi bi-phone me-3 fs-16 align-middle text-muted"></i>
                            </div>
                            <div class="lh-1 flex-fill">
                                <p class="mb-1">
                                    <span class="fw-medium">Mobile-LG-1023</span>
                                </p>
                                <p class="mb-0">
                                    <span class="text-muted fs-13">Manchester,
                                        UK-Nov 30,
                                        04:45PM</span>
                                </p>
                            </div>
                            <div class="dropdown mt-sm-0 mt-2">
                                <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-light"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fe fe-more-vertical"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:void(0);">Action</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Another
                                            action</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Something
                                            else
                                            here</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-sm-flex d-block align-items-top">
                            <div class="lh-1 mb-sm-0 mb-2"><i class="bi bi-laptop me-3 fs-16 align-middle text-muted"></i>
                            </div>
                            <div class="lh-1 flex-fill">
                                <p class="mb-1">
                                    <span class="fw-medium">Lenovo-1291203</span>
                                </p>
                                <p class="mb-0">
                                    <span class="text-muted fs-13">England,
                                        UK-Aug 12,
                                        12:25PM</span>
                                </p>
                            </div>
                            <div class="dropdown mt-sm-0 mt-2">
                                <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-light"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fe fe-more-vertical"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:void(0);">Action</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Another
                                            action</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Something
                                            else
                                            here</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-sm-flex d-block align-items-top">
                            <div class="lh-1 mb-sm-0 mb-2"><i class="bi bi-laptop me-3 fs-16 align-middle text-muted"></i>
                            </div>
                            <div class="lh-1 flex-fill">
                                <p class="mb-1">
                                    <span class="fw-medium">Macbook-Suzika</span>
                                </p>
                                <p class="mb-0">
                                    <span class="text-muted fs-13">Brightoon,
                                        UK-Jul 18,
                                        8:34AM</span>
                                </p>
                            </div>
                            <div class="dropdown mt-sm-0 mt-2">
                                <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-light"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fe fe-more-vertical"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:void(0);">Action</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Another
                                            action</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Something
                                            else
                                            here</a></li>
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
                                    <span class="text-muted fs-13">Darlington,
                                        UK-Jan 14,
                                        11:14AM</span>
                                </p>
                            </div>
                            <div class="dropdown mt-sm-0 mt-2">
                                <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-light"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fe fe-more-vertical"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:void(0);">Action</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Another
                                            action</a>
                                    </li>
                                    <li><a class="dropdown-item" href="javascript:void(0);">Something
                                            else
                                            here</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
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
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" checked="">
                        <label class="btn btn-outline-light" for="btnradio1"><i
                                class="ri-lock-unlock-line me-2 d-inline-block"></i>Pin</label>
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio2">
                        <label class="btn btn-outline-light" for="btnradio2"><i
                                class="ri-lock-password-line me-2 d-inline-block"></i>Password</label>
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio3">
                        <label class="btn btn-outline-light" for="btnradio3"><i
                                class="ri-fingerprint-line me-2 d-inline-block"></i>Finger
                            Print</label>
                    </div>
                </div>
            </div>
            <div class="toggle toggle-primary on mb-0 ms-0 mt-sm-0 mt-2" id="authentication">
                <span></span>
            </div>
        </div>
        <div class="d-sm-flex d-block align-items-top mb-4 justify-content-between">
            <div class="w-75">
                <p class="fs-14 mb-1 fw-medium">Recovery Mail</p>
                <p class="fs-13 text-muted mb-0">Incase of forgetting password mails
                    are sent to heifo@gmail.com</p>
            </div>
            <div class="toggle toggle-primary on mb-0 ms-0 mt-sm-0 mt-2" id="recovery-mail">
                <span></span>
            </div>
        </div>
        <div class="d-sm-flex d-block align-items-top mb-4 justify-content-between">
            <div>
                <p class="fs-14 mb-1 fw-medium">SMS Recovery</p>
                <p class="fs-13 text-muted mb-0">SMS are sent to 9102312xx in case of
                    recovery</p>
            </div>
            <div class="toggle toggle-primary on mb-0 ms-0 mt-sm-0 mt-2" id="sms-recovery">
                <span></span>
            </div>
        </div>
        <div class="d-flex align-items-top justify-content-between">
            <div>
                <p class="fs-14 mb-1 fw-medium">Reset Password</p>
                <p class="fs-13 text-muted">Password should be min of <b class="text-success">8
                        digits<sup>*</sup></b>,atleast <b class="text-success">One Capital
                        letter<sup>*</sup></b> and <b class="text-success">One Special
                        Character<sup>*</sup></b>
                    included.</p>
                <div class="mb-2">
                    <label for="current-password" class="form-label">Current
                        Password</label>
                    <input type="text" class="form-control" id="current-password" placeholder="Current Password">
                </div>
                <div class="mb-2">
                    <label for="new-password" class="form-label">New Password</label>
                    <input type="text" class="form-control" id="new-password" placeholder="New Password">
                </div>
                <div class="mb-0">
                    <label for="confirm-password" class="form-label">Confirm
                        Password</label>
                    <input type="text" class="form-control" id="confirm-password" placeholder="Confirm Password">
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
                        <div class="lh-1 mb-sm-0 mb-2"><i class="bi bi-phone me-3 fs-16 align-middle text-muted"></i>
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
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-light"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fe fe-more-vertical"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Another action</a>
                                </li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Something else
                                        here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="d-sm-flex d-block align-items-top">
                        <div class="lh-1 mb-sm-0 mb-2"><i class="bi bi-laptop me-3 fs-16 align-middle text-muted"></i>
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
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-light"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fe fe-more-vertical"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Another action</a>
                                </li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Something else
                                        here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="d-sm-flex d-block align-items-top">
                        <div class="lh-1 mb-sm-0 mb-2"><i class="bi bi-laptop me-3 fs-16 align-middle text-muted"></i>
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
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-light"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fe fe-more-vertical"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Another action</a>
                                </li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Something else
                                        here</a>
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
                            <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-light"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fe fe-more-vertical"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Another action</a>
                                </li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Something else
                                        here</a>
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
                    <select class="form-control" name="mail-language" id="mail-language" multiple>
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
                        <input class="form-check-input" type="radio" name="images-open" id="images-open1">
                        <label class="form-check-label" for="images-open1">
                            Always Open Images
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="images-open" id="images-hide2"
                            checked="">
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
                        <input class="form-check-input" type="radio" name="keyboard-enable" id="keyboard-enable1">
                        <label class="form-check-label" for="keyboard-enable1">
                            Keyboard Shortcuts Enable
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="keyboard-enable" id="keyboard-disable2"
                            checked="">
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
                        <input class="form-check-input" type="checkbox" value="" id="desktop-notifications"
                            checked="">
                        <label class="form-check-label" for="desktop-notifications">
                            Desktop Notifications
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="mobile-notifications">
                        <label class="form-check-label" for="mobile-notifications">
                            Mobile Notifications
                        </label>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="float-sm-end">
                        <a href="javascript:void(0)" class="btn btn-success-ghost btn-sm">Learn-more</a>
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
                    <select class="form-control" data-trigger name="mail-per-page" id="mail-per-page">
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
                        <input class="form-check-input" type="radio" name="mail-composer" id="mail-composeron1">
                        <label class="form-check-label" for="mail-composeron1">
                            Mail Composer On
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="mail-composer" id="mail-composeroff2"
                            checked="">
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
                        <input class="form-check-input" type="radio" name="auto-correct" id="auto-correcton1">
                        <label class="form-check-label" for="auto-correcton1">
                            Auto Correct On
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="auto-correct" id="auto-correctoff2"
                            checked="">
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
                        <input class="form-check-input" type="checkbox" value="" id="on-keyboard"
                            checked="">
                        <label class="form-check-label" for="on-keyboard">
                            On Keyboard Action
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="on-buttonclick">
                        <label class="form-check-label" for="on-buttonclick">
                            On Button Click
                        </label>
                    </div>
                </div>
                <div class="col-xl-5">
                    <div class="float-sm-end">
                        <a href="javascript:void(0)" class="btn btn-success-ghost btn-sm">Learn-more</a>
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
@endsection

@section('scripts')
@endsection
