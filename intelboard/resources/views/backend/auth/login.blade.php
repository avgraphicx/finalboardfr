@extends('backend.layouts.master')

@section('title', 'Admin Login')

@section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-6 col-sm-8 col-12">
                <div class="card custom-card border-0 my-4">
                    <div class="card-body p-5">

                        <div class="mb-4 d-flex justify-content-center">
                            <a href="{{ url('/backend') }}">
                                <img src="{{ asset('build/assets/images/brand-logos/toggle-logo.png') }}" alt="logo"
                                    class="desktop-dark">
                            </a>
                        </div>

                        <div>
                            <h4 class="mb-1 fw-semibold text-center">Backend Login</h4>
                            <p class="mb-4 text-muted fw-normal text-center">Admin access only.</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('backend.login.submit') }}">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <label for="signin-email" class="form-label text-default">Email</label>
                                    <input type="email" class="form-control" id="signin-email"
                                        placeholder="email@example.com" name="email" value="{{ old('email') }}" required
                                        autofocus>
                                </div>
                                <div class="col-xl-12 mb-2">
                                    <label for="signin-password" class="form-label text-default d-block">Password</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="signin-password"
                                            placeholder="password" name="password" required>
                                        <a href="javascript:void(0);" class="show-password-button text-muted"
                                            onclick="createpassword('signin-password',this)" id="button-addon2"><i
                                                class="ri-eye-off-line align-middle"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid mt-3">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
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
