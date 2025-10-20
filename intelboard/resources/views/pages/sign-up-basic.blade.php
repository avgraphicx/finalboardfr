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
                                <img src="{{ asset('build/assets/images/brand-logos/toggle-logo.png') }}" alt="logo"
                                    class="desktop-dark">
                            </a>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-semibold">Sign Up</h4>
                            <p class="mb-4 text-muted fw-normal">Join us by creating a free account !</p>
                        </div>
                        <div class="row gy-3">
                            <div class="col-xl-12">
                                <label for="signin-email" class="form-label text-default">Email</label>
                                <input type="text" class="form-control" id="signin-email" placeholder="Enter Email"
                                    value="tomphillip21@gmail.com">
                            </div>
                            <div class="col-xl-12 mb-2">
                                <label for="signin-password" class="form-label text-default d-block">Password</label>
                                <div class="position-relative">
                                    <input type="password" class="form-control" id="signin-password"
                                        placeholder="Enter Password" value="12345678">
                                    <a href="javascript:void(0);" class="show-password-button text-muted"
                                        onclick="createpassword('signin-password',this)" id="button-addon2"><i
                                            class="ri-eye-off-line align-middle"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid mt-3">
                            <a href="{{ url('index') }}" class="btn btn-primary">Create Account</a>
                        </div>
                        <div class="text-center my-3 authentication-barrier">
                            <span class="op-4 fs-13">OR</span>
                        </div>
                        <div class="d-grid mb-3">
                            <button
                                class="btn btn-white btn-w-lg border d-flex align-items-center justify-content-center flex-fill mb-3">
                                <span class="avatar avatar-xs">
                                    <img src="{{ asset('build/assets/images/media/apps/google.png') }}" alt="">
                                </span>
                                <span class="lh-1 ms-2 fs-13 text-default fw-medium">Signup with Google</span>
                            </button>
                            <button
                                class="btn btn-white btn-w-lg border d-flex align-items-center justify-content-center flex-fill">
                                <span class="avatar avatar-xs flex-shrink-0">
                                    <img src="{{ asset('build/assets/images/media/apps/facebook.png') }}" alt="">
                                </span>
                                <span class="lh-1 ms-2 fs-13 text-default fw-medium">Signup with Facebook</span>
                            </button>
                        </div>
                        <div class="text-center mt-3 fw-medium">
                            Already have a account? <a href="{{ url('sign-in-basic') }}" class="text-primary">Sign In</a>
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
