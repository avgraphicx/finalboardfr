@extends('layouts.custom-master')

@php
    // Passing the bodyClass variable from the view to the layout
    $bodyClass = 'authentication-background';
@endphp

@section('styles')
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
                        <div class="mb-4">
                            <a href="{{ url('index') }}">
                                <img src="{{ asset('build/assets/images/brand-logos/desktop-dark.png') }}"
                                    alt="{{ __('messages.logo') }}" class="desktop-dark">
                            </a>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-semibold">{{ __('messages.register_title') }}</h4>
                            <p class="mb-4 text-muted fw-normal">{{ __('messages.join_us_by_creating_account') }}</p>
                        </div>
                        <form action="{{ route('register.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan" value="{{ $plan }}">
                            <input type="hidden" name="interval" value="{{ $interval }}">
                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <label for="name"
                                        class="form-label text-default">{{ __('messages.register_full_name_label') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name"
                                        placeholder="{{ __('messages.register_full_name_placeholder') }}"
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-xl-12">
                                    <label for="signin-email"
                                        class="form-label text-default">{{ __('messages.email') }}</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="signin-email" name="email" placeholder="{{ __('messages.enter_email') }}"
                                        value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-xl-12">
                                    <label for="phone"
                                        class="form-label text-default">{{ __('messages.register_phone_label') }}</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" placeholder="{{ __('messages.enter_phone_number') }}"
                                        value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-xl-12 mb-2">
                                    <label for="signin-password"
                                        class="form-label text-default d-block">{{ __('messages.register_password_label') }}</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="signin-password" name="password"
                                            placeholder="{{ __('messages.enter_password') }}" required>
                                        <a href="javascript:void(0);" class="show-password-button text-muted"
                                            onclick="createpassword('signin-password',this)" id="button-addon2"><i
                                                class="ri-eye-off-line align-middle"></i></a>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid mt-3">
                                <button type="submit" class="btn btn-primary">{{ __('messages.create_account') }}</button>
                            </div>
                        </form>
                        <div class="text-center my-3 authentication-barrier">
                            <span class="op-4 fs-13">{{ __('messages.or') }}</span>
                        </div>
                        <div class="d-grid mb-3">
                            <button
                                class="btn btn-white btn-w-lg border d-flex align-items-center justify-content-center flex-fill mb-3">
                                <span class="avatar avatar-xs">
                                    <img src="{{ asset('build/assets/images/media/apps/google.png') }}" alt="">
                                </span>
                                <span
                                    class="lh-1 ms-2 fs-13 text-default fw-medium">{{ __('messages.signup_with_google') }}</span>
                            </button>
                        </div>
                        <div class="text-center mt-3 fw-medium">
                            {{ __('messages.register_already_have_account') }} <a href="{{ route('login') }}"
                                class="text-primary">{{ __('messages.sign_in') }}</a>
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
