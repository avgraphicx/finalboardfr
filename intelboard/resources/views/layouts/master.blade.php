<!DOCTYPE html>
<html lang="{{ auth()->check() ? auth()->user()->preference?->language ?? app()->getLocale() : app()->getLocale() }}"
    dir="ltr" data-nav-layout="vertical" data-vertical-style="default" data-page-style="regular"
    data-nav-style="menu-click" data-width="fullwidth" data-header-position="fixed" data-menu-position="fixed"
    loader="enable">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Intelboard - @yield('title', __('messages.dashboard'))</title>
    <meta name="Description" content="{{ __('messages.app_description') }}">
    <meta name="Author" content="Intelboard">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('build/assets/images/brand-logos/favicon.ico') }}" type="image/x-icon">

    <!-- Main Theme Js -->
    <script src="{{ asset('build/assets/main.js') }}"></script>

    <!-- ICONS CSS -->
    <link href="{{ asset('build/assets/icon-fonts/icons.css') }}" rel="stylesheet">

    @include('layouts.components.styles')

    <!-- APP CSS & APP SCSS -->
    @vite(['resources/sass/app.scss'])

    @yield('styles')

</head>

<body class="">

    <div class="progress-top-bar"></div>

    <!-- Start::main-switcher -->
    {{-- @include('layouts.components.switcher') --}}
    <!-- End::main-switcher -->

    <!-- Loader -->
    <div id="loader">
        <img src="{{ asset('build/assets/images/media/loader.svg') }}" alt="">
    </div>
    <!-- Loader -->

    <div class="page">

        <!-- Start::main-header -->
        @include('layouts.components.main-header')
        <!-- End::main-header -->

        <!-- Start::main-sidebar -->
        @include('layouts.components.main-sidebar')
        <!-- End::main-sidebar -->

        <!-- Start::app-content -->
        <div class="main-content app-content plr-2">
            {{-- <div class="container-fluid page-container main-body-container"> --}}

            @yield('content')

            {{-- </div> --}}
        </div>
        <!-- End::content  -->

        <!-- Start::main-footer -->
        @include('layouts.components.footer')
        <!-- End::main-footer -->

        <!-- Start::main-modal -->
        @include('layouts.components.modal')
        <!-- End::main-modal -->

        @yield('modals')

    </div>
    <div class="scrollToTop" style="display: flex;">
        <span class="arrow lh-1"><i class="ti ti-arrow-big-up fs-18"></i></span>
    </div>
    <!-- Scripts -->
    @include('layouts.components.scripts')

    <!-- Sticky JS -->
    <script src="{{ asset('build/assets/sticky.js') }}"></script>

    <!-- Custom-Switcher JS -->
    @vite('resources/assets/js/custom-switcher.js')

    <!-- App JS-->
    @vite('resources/js/app.js')

    <!-- End Scripts -->

</body>

</html>
