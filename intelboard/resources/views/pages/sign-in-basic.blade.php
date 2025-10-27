@extends('layouts.custom-master')

@php
    // Passing the bodyClass variable from the view to the layout
    $bodyClass = 'authentication-background';
    // Logic for Language Switcher
    $currentLocale = Session::get('locale') ?: config('app.fallback_locale');
    $nextLocale = $currentLocale === 'fr' ? 'en' : 'fr';
@endphp

@section('styles')
    {{-- Static Primary Color Fix for Login Page --}}
    <style>
        /* Primary color: #2596be (RGB 37, 150, 190) */
        :root {
            --primary-rgb: 37, 150, 190;
        }
    </style>
@endsection

@section('content')
    <div class="authentication-basic-background">
        <img src="{{ asset('build/assets/images/media/backgrounds/9.png') }}" alt="">
    </div>

    <div class="container">
        <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-6 col-sm-8 col-12">
                <div class="card custom-card border-0 my-4">
                    <div class="card-body p-5">

                        {{-- START FORM FOR LOGIN --}}
                        <form method="POST" action="{{ url('login') }}">
                            @csrf

                            {{-- LOGO AND LANGUAGE SWITCHER --}}
                            <div class="mb-4 d-flex align-items-center justify-content-between">
                                <div>
                                    <a href="{{ url('index') }}">
                                        <img src="{{ asset('build/assets/images/brand-logos/toggle-logo.png') }}"
                                            alt="{{ __('messages.logo') }}" class="desktop-dark">
                                    </a>
                                </div>

                                {{-- Language Switcher --}}
                                <a href="{{ route('set.locale', $nextLocale) }}" class="header-link"
                                    title="{{ __('messages.language_en') }}">
                                    @if ($currentLocale == 'fr')
                                        <img src="{{ asset('build/assets/images/flags/french_flag.jpg') }}"
                                            alt="{{ __('messages.flag') }}" class="rounded-circle"
                                            style="width: 25px; height: 25px; border: 1px solid #ddd;">
                                    @else
                                        <img src="{{ asset('build/assets/images/flags/us_flag.jpg') }}"
                                            alt="{{ __('messages.flag') }}" class="rounded-circle"
                                            style="width: 25px; height: 25px; border: 1px solid #ddd;">
                                    @endif
                                </a>
                            </div>
                            {{-- END LOGO AND LANGUAGE SWITCHER --}}

                            <div>
                                <h4 class="mb-1 fw-semibold">{{ __('messages.login_title') }}</h4>
                                <p class="mb-4 text-muted fw-normal">{{ __('messages.app_description') }}</p>
                            </div>

                            {{-- Display Validation Errors --}}
                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <label for="signin-email"
                                        class="form-label text-default">{{ __('messages.login_email_label') }}</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="signin-email" placeholder="{{ __('messages.login_email_placeholder') }}"
                                        name="email" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-xl-12 mb-2">
                                    <label for="signin-password"
                                        class="form-label text-default d-block">{{ __('messages.login_password_label') }}</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="signin-password"
                                            placeholder="{{ __('messages.login_password_placeholder') }}" name="password"
                                            required>
                                        <a href="javascript:void(0);" class="show-password-button text-muted"
                                            onclick="createpassword('signin-password',this)" id="button-addon2"><i
                                                class="ri-eye-off-line align-middle"></i></a>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <div class="mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                {{ __('messages.login_remember_me') }}
                                            </label>
                                            <a href="{{ url('reset-password-basic') }}"
                                                class="float-end link-danger fw-medium fs-12">{{ __('messages.login_forgot_password') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid mt-3">
                                <button type="submit" class="btn btn-primary">{{ __('messages.login_button') }}</button>
                            </div>
                        </form>
                        {{-- END FORM FOR LOGIN --}}

                        <div class="text-center my-3 authentication-barrier">
                            <span class="op-4 fs-13">{{ __('messages.or_use_email') }}</span>
                        </div>
                        <div class="d-grid mb-3">
                            {{-- Login with Google button (changed to anchor tag) --}}
                            <a href="{{ url('auth/google/redirect') }}"
                                class="btn btn-white btn-w-lg border d-flex align-items-center justify-content-center flex-fill">
                                <span class="avatar avatar-xs">
                                    <img src="{{ asset('build/assets/images/media/apps/google.png') }}" alt="Google Icon">
                                </span>
                                <span
                                    class="lh-1 ms-2 fs-13 text-default fw-medium">{{ __('messages.register_with_google') }}</span>
                            </a>
                        </div>
                        <div class="text-center mt-3 fw-medium">
                            {{ __('messages.login_no_account') }} <a href="{{ route('signup') }}"
                                class="text-primary">{{ __('messages.register_title') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Show Password JS -->
    <script src="{{ asset('build/assets/show-password.js') }}"></script>
@endsection
