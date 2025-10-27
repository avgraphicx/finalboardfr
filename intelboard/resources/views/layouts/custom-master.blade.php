<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" data-vertical-style="overlay" data-theme-mode="light"
    data-header-styles="light" data-menu-styles="light" data-toggled="close">

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
    <script src="{{ asset('build/assets/authentication-main.js') }}"></script>

    <!-- Bootstrap Css -->
    <link id="style" href="{{ asset('build/assets/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- ICONS CSS -->
    <link href="{{ asset('build/assets/icon-fonts/icons.css') }}" rel="stylesheet">

    <!-- APP CSS & APP SCSS -->
    @vite(['resources/sass/app.scss'])

    @yield('styles')

</head>

<body class="authentication-background">

    <!-- Start Switcher -->
    @include('layouts.components.custom-switcher')
    <!-- End Switcher -->

    @include('layouts.components.alerts')

    @yield('content')

    <!-- Bootstrap JS -->
    <script src="{{ asset('build/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    @yield('scripts')

</body>

</html>
