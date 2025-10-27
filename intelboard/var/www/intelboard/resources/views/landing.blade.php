<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.landing_meta_title') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Fonts - Space Grotesk -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="{{ asset('build/assets/landing.css') }}" rel="stylesheet">
    <link href="{{ asset('build/assets/icon-fonts/RemixIcons/fonts/remixicon.css') }}" rel="stylesheet">

</head>

<body>

    <!-- 1. Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#"><img
                    src="{{ asset('build/assets/images/brand-logos/desktop-logo.png') }}" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="{{ __('messages.toggle_navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto me-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#hero">{{ __('messages.home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">{{ __('messages.features') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#workflow">{{ __('messages.how_it_works_label') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#analytics">{{ __('messages.analytics') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">{{ __('messages.pricing') }}</a>
                    </li>
                </ul>
                <a href="{{ route('login') }}"
                    class="btn btn-primary">{{ __('messages.login_button') ?? 'Login' }}</a>
            </div>
        </div>
    </nav>

    <!-- 2. Hero Section -->
    <header id="hero" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4">{{ __('messages.manage_logistics') }} <span
                            class="text-primary">{{ __('messages.intelboard') }}</span></h1>
                    <p class="lead my-4">
                        {{ __('messages.platform_description') }}
                    </p>
                    <a href="{{ route('subscriptions.checkout', ['plan' => 'bronze']) }}"
                        class="btn btn-primary btn-lg me-2">{{ __('messages.get_started_free') }}</a>
                    <a href="#" class="btn btn-outline-primary btn-lg">{{ __('messages.learn_more') }}</a>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0" id="hero-image">
                    <div class="heroCarousel carousel slide rounded-3 shadow-lg" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('build/assets/images/ss/s2.png') }}" class="d-block w-100 rounded-3"
                                    alt="{{ __('messages.dashboard_view_1_alt') }}">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('build/assets/images/ss/s4.png') }}" class="d-block w-100 rounded-3"
                                    alt="{{ __('messages.dashboard_view_2_alt') }}">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('build/assets/images/ss/s5.png') }}" class="d-block w-100 rounded-3"
                                    alt="{{ __('messages.dashboard_view_3_alt') }}">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target=".heroCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">{{ __('messages.previous') }}</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target=".heroCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">{{ __('messages.next') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- 3. Features Section -->
    <section id="features" class="section-padding bg-primary-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <span class="text-primary fw-bold text-uppercase small">{{ __('messages.core_features') }}</span>
                    <h2 class="section-title mt-2">{{ __('messages.everything_you_need') }}</h2>
                    <p class="mb-5 text-muted">{{ __('messages.comprehensive_suite') }}</p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Feature 1: Driver Management -->
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="bi bi-person-vcard-fill feature-icon"></i>
                        </div>
                        <h3 class="h5">{{ __('messages.driver_management') }}</h3>
                        <p class="text-muted small">{{ __('messages.feature_driver_management_desc') }}</p>
                    </div>
                </div>

                <!-- Feature 2: Invoice & Payment -->
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="bi bi-receipt-cutoff feature-icon"></i>
                        </div>
                        <h3 class="h5">{{ __('messages.invoice_payment') }}</h3>
                        <p class="text-muted small">{{ __('messages.feature_invoice_payment_desc') }}</p>
                    </div>
                </div>

                <!-- Feature 3: Analytics & Reporting -->
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="bi bi-pie-chart-fill feature-icon"></i>
                        </div>
                        <h3 class="h5">{{ __('messages.analytics_reporting') }}</h3>
                        <p class="text-muted small">{{ __('messages.feature_analytics_reporting_desc') }}</p>
                    </div>
                </div>

                <!-- Feature 4: Financial Tracking -->
                <div class="col-lg-6 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="bi bi-cash-coin feature-icon"></i>
                        </div>
                        <h3 class="h5">{{ __('messages.financial_tracking') }}</h3>
                        <p class="text-muted small">{{ __('messages.feature_financial_tracking_desc') }}</p>
                    </div>
                </div>

                <!-- Feature 5: Security & Roles -->


                <!-- Feature 6: Multi-Language & Themes -->
                <div class="col-lg-6 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <i class="bi bi-translate feature-icon"></i>
                        </div>
                        <h3 class="h5">{{ __('messages.multi_language_themes') }}</h3>
                        <p class="text-muted small">{{ __('messages.feature_multilang_themes_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Workflow Section -->
    <section id="workflow" class="section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <span
                        class="text-primary fw-bold text-uppercase small">{{ __('messages.how_it_works_label') }}</span>
                    <h2 class="section-title mt-2">{{ __('messages.how_it_works') }}</h2>
                </div>
            </div>

            <div class="row g-4 align-items-stretch">
                <!-- Step 1 -->
                <div class="col-md">
                    <div class="workflow-step">
                        <div class="step-number">1</div>
                        <h3 class="h5">{{ __('messages.add_drivers') }}</h3>
                        <p class="text-muted small">{{ __('messages.add_drivers_description') }}</p>
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="col-md">
                    <div class="workflow-step">
                        <div class="step-number">2</div>
                        <h3 class="h5">{{ __('messages.upload_invoices') }}</h3>
                        <p class="text-muted small">{{ __('messages.upload_invoices_description') }}</p>
                    </div>
                </div>
                <!-- Step 3 -->
                <div class="col-md">
                    <div class="workflow-step">
                        <div class="step-number">3</div>
                        <h3 class="h5">{{ __('messages.calculate_track') }}</h3>
                        <p class="text-muted small">{{ __('messages.calculate_track_description') }}</p>
                    </div>
                </div>
                <!-- Step 4 -->
                <div class="col-md">
                    <div class="workflow-step">
                        <div class="step-number">4</div>
                        <h3 class="h5">{{ __('messages.view_analytics_workflow') }}</h3>
                        <p class="text-muted small">{{ __('messages.view_analytics_description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Analytics Showcase Section -->
    <section id="analytics" class="section-padding bg-primary-light">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span
                        class="text-primary fw-bold text-uppercase small">{{ __('messages.analytics_label') }}</span>
                    <h2 class="section-title mt-2">{{ __('messages.data_driven_decisions') }}</h2>
                    <p class="lead text-muted">{{ __('messages.beyond_spreadsheets') }}</p>
                    <ul class="list-unstyled mt-4 fs-6"> <!-- Adjusted font size -->
                        <li class="mb-2 d-flex align-items-center"><i
                                class="bi bi-check-circle-fill text-primary me-2 fs-5"></i>
                            {{ __('messages.view_total_invoices_vs_benefits') }}</li>
                        <li class="mb-2 d-flex align-items-center"><i
                                class="bi bi-check-circle-fill text-primary me-2 fs-5"></i>
                            {{ __('messages.analyze_weekly_earnings') }}</li>
                        <li class="mb-2 d-flex align-items-center"><i
                                class="bi bi-check-circle-fill text-primary me-2 fs-5"></i>
                            {{ __('messages.track_average_metrics') }}</li>
                        <li class="mb-2 d-flex align-items-center"><i
                                class="bi bi-check-circle-fill text-primary me-2 fs-5"></i>
                            {{ __('messages.monitor_business_statistics') }}</li>
                    </ul>
                </div>
                <div class="col-lg-6" id="analytics-image">
                    <div class="analyticsCarousel carousel slide rounded-3 shadow-lg" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('build/assets/images/ss/s1.png') }}"
                                    class="d-block w-100 rounded-3" alt="{{ __('messages.analytics_view_1_alt') }}">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('build/assets/images/ss/s3.png') }}"
                                    class="d-block w-100 rounded-3" alt="{{ __('messages.analytics_view_2_alt') }}">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target=".analyticsCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">{{ __('messages.previous') }}</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target=".analyticsCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">{{ __('messages.next') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. User Roles Section -->
    {{-- <section id="roles" class="section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <span class="text-primary fw-bold text-uppercase small">BUILT FOR YOUR TEAM</span>
                    <h2 class="section-title mt-2">Secure Access for Every Role</h2>
                    <p class="mb-5 text-muted">Intelboard ensures everyone on your team has the right level of access
                        to get their job done securely.</p>
                </div>
            </div>
            <div class="row g-4 text-center">
                <!-- Broker/Manager -->
                <div class="col-lg-6">
                    <div class="p-4 rounded-3 border h-100">
                        <div class="feature-icon-box mx-auto">
                            <i class="bi bi-person-workspace feature-icon"></i>
                        </div>
                        <h3 class="h4 mt-3">Brokers / Managers</h3>
                        <p class="text-muted small">The core users. Manage drivers, upload and process invoices, and
                            track driver payments and performance.</p>
                    </div>
                </div>
                <!-- Supervisor -->
                <div class="col-lg-6">
                    <div class="p-4 rounded-3 border h-100">
                        <div class="feature-icon-box mx-auto">
                            <i class="bi bi-person-lines-fill feature-icon"></i>
                        </div>
                        <h3 class="h4 mt-3">Supervisors</h3>
                        <p class="text-muted small">View-only access. Monitor key metrics, view reports, and track
                            performance without data editing rights.</p>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- 7. Pricing Section -->
    <section id="pricing" class="section-padding">
        <div class="container">
            <!-- Start:: row-1 -->
            <div class="row d-flex justify-content-center">
                <div class="pricing-heading-section text-center mb-5">
                    <span class="badge bg-primary-transparent rounded-pill">
                        {{ __('messages.pricing_plans') }}
                    </span>
                    <h2 class="fw-semibold mt-3 section-title">{{ __('messages.pricing_plans') }}</h2>
                    <span class="d-block text-muted fs-16 mb-3">{{ __('messages.pricing_description') }}</span>
                    <div class="tab-style-1 border p-1 bg-white rounded-pill d-inline-block">
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link rounded-pill fw-medium active"
                                    data-bs-toggle="pill" data-bs-target="#pricing-monthly" aria-selected="true"
                                    role="tab">{{ __('messages.monthly_label') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link rounded-pill fw-medium" data-bs-toggle="pill"
                                    data-bs-target="#pricing-quarterly" aria-selected="false" role="tab"
                                    tabindex="-1">{{ __('messages.quarterly_label') }} <span
                                        class="badge bg-success-transparent text-warning ms-1">{{ __('messages.save_10') }}</span></button>
                                <!-- Added Quarterly Discount Badge -->

                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link rounded-pill fw-medium" data-bs-toggle="pill"
                                    data-bs-target="#pricing-yearly" aria-selected="false" role="tab"
                                    tabindex="-1">{{ __('messages.yearly_label') }} <span
                                        class="badge bg-success-transparent text-success ms-1">{{ __('messages.save_20') }}</span></button>
                                <!-- Added Quarterly Discount Badge -->

                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="tab-content">
                        <!-- Monthly -->
                        <div class="tab-pane show active p-0 border-0" id="pricing-monthly" role="tabpanel">
                            <div class="row g-4">
                                <!-- Individual Plan (Monthly) -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card custom-card dashboard-main-card pricing-card">
                                        <div class="card-body p-4">
                                            <div class="lh-1 mb-3">
                                                <span
                                                    class="avatar avatar-lg avatar-rounded bg-bronze-transparent svg-bronze">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                        height="32" fill="#000000" viewBox="0 0 256 256">
                                                        <path
                                                            d="M230.93,220a8,8,0,0,1-6.93,4H32a8,8,0,0,1-6.92-12c15.23-26.33,38.7-45.21,66.09-54.16a72,72,0,1,1,73.66,0c27.39,8.95,50.86,27.83,66.09,54.16A8,8,0,0,1,230.93,220Z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <h5 class="fw-semibold">{{ __('messages.bronze') }}</h5>
                                            <p class="text-muted small">{{ __('messages.bronze_description') }}</p>
                                            <div class="pricing-count my-3">
                                                <div class="d-flex align-items-end gap-1">
                                                    <h2 class="fw-semibold mb-0 lh-1 display-5">$69<span
                                                            class="fs-5">.99</span></h2>
                                                    <span
                                                        class="fs-6 text-muted">{{ __('messages.month_suffix') }}</span>
                                                </div>
                                            </div>
                                            <hr class="section-devider my-4">
                                            <ul class="list-unstyled pricing-features-list mb-4">
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.up_to_10_drivers') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.unlimited_drivers') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.weekly_statistics') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.dashboard_statistics') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.calculate_one_invoice') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.calculate_50_invoices') }}</span>
                                                </li>
                                                {{-- <li>
                                                   <i class="ri-checkbox-circle-fill text-success"></i>
                                                   <span class="fw-medium">{{ __('messages.up_to_10_drivers') }}</span>
                                                </li> --}}
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.supervisor_account') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span class="fw-medium">{{ __('messages.custom_invoice') }}</span>
                                                </li>
                                            </ul>
                                            <div class="d-grid mt-auto">
                                                <a href="{{ route('subscriptions.checkout', ['plan' => 'bronze']) }}"
                                                    class="btn btn-lg btn-primary">{{ __('messages.get_started') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Team Plan (Monthly) -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card custom-card dashboard-main-card pricing-card ">
                                        <!-- Recommended -->
                                        <div class="card-body p-4">
                                            {{-- <span
                                                class="badge bg-dark text-white pricing-recommended-badge">Recommended</span> --}}
                                            <div class="lh-1 mb-3">
                                                <span
                                                    class="avatar avatar-lg avatar-rounded bg-gold-transparent svg-gold">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                        height="32" fill="#000000" viewBox="0 0 256 256">
                                                        <path
                                                            d="M164.47,195.63a8,8,0,0,1-6.7,12.37H10.23a8,8,0,0,1-6.7-12.37,95.83,95.83,0,0,1,47.22-37.71,60,60,0,1,1,66.5,0A95.83,95.83,0,0,1,164.47,195.63Zm87.91-.15a95.87,95.87,0,0,0-47.13-37.56A60,60,0,0,0,144.7,54.59a4,4,0,0,0-1.33,6A75.83,75.83,0,0,1,147,150.53a4,4,0,0,0,1.07,5.53,112.32,112.32,0,0,1,29.85,30.83,23.92,23.92,0,0,1,3.65,16.47,4,4,0,0,0,3.95,4.64h60.3a8,8,0,0,0,7.73-5.93A8.22,8.22,0,0,0,252.38,195.48Z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <h5 class="fw-semibold">{{ __('messages.gold') }}</h5>
                                            <p class="text-muted small">{{ __('messages.gold_description') }}</p>
                                            <div class="pricing-count my-3">
                                                <div class="d-flex align-items-end gap-1">
                                                    <h2 class="fw-semibold mb-0 lh-1 display-5">$89<span
                                                            class="fs-5">.99</span></h2>
                                                    <span
                                                        class="fs-6 text-muted">{{ __('messages.month_suffix') }}</span>
                                                </div>
                                            </div>
                                            <hr class="section-devider my-4">
                                            <ul class="list-unstyled pricing-features-list mb-4">
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.up_to_50_drivers') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.unlimited_drivers') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.weekly_statistics') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.dashboard_statistics') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.calculate_one_invoice') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.calculate_50_invoices') }}</span>
                                                </li>
                                                {{-- <li>
                                                   <i class="ri-checkbox-circle-fill text-success"></i>
                                                   <span class="fw-medium">{{ __('messages.up_to_10_drivers') }}</span>
                                                </li> --}}
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.supervisor_account') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span class="fw-medium">{{ __('messages.custom_invoice') }}</span>
                                                </li>
                                            </ul>
                                            <div class="d-grid mt-auto">
                                                <a href="{{ route('subscriptions.checkout', ['plan' => 'gold']) }}"
                                                    class="btn btn-lg btn-primary">{{ __('messages.get_started') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Enterprise Plan (Monthly) -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card custom-card dashboard-main-card pricing-card ">
                                        <div class="card-body p-4">
                                            <div class="lh-1 mb-3">
                                                <span
                                                    class="avatar avatar-lg avatar-rounded bg-diamond-transparent svg-diamond">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                        height="32" fill="#000000" viewBox="0 0 256 256">
                                                        <path
                                                            d="M64.12,147.8a4,4,0,0,1-4,4.2H16a8,8,0,0,1-7.8-6.17,8.35,8.35,0,0,1,1.62-6.93A67.79,67.79,0,0,1,37,117.51a40,40,0,1,1,66.46-35.8,3.94,3.94,0,0,1-2.27,4.18A64.08,64.08,0,0,0,64,144C64,145.28,64,146.54,64.12,147.8Zm182-8.91A67.76,67.76,0,0,0,219,117.51a40,40,0,1,0-66.46-35.8,3.94,3.94,0,0,0,2.27,4.18A64.08,64.08,0,0,1,192,144c0,1.28,0,2.54-.12,3.8a4,4,0,0,0,4,4.2H240a8,8,0,0,0,7.8-6.17A8.33,8.33,0,0,0,246.17,138.89Zm-89,43.18a48,48,0,1,0-58.37,0A72.13,72.13,0,0,0,65.07,212,8,8,0,0,0,72,224H184a8,8,0,0,0,6.93-12A72.15,72.15,0,0,0,157.19,182.07Z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <h5 class="fw-semibold">{{ __('messages.diamond') }}</h5>
                                            <p class="text-muted small">{{ __('messages.diamond_description') }}</p>
                                            <div class="pricing-count my-3">
                                                <div class="d-flex align-items-end gap-1">
                                                    <h2 class="fw-semibold mb-0 lh-1 display-5">$129<span
                                                            class="fs-5">.99</span></h2>
                                                    <span
                                                        class="fs-6 text-muted">{{ __('messages.month_suffix') }}</span>
                                                </div>
                                            </div>
                                            <hr class="section-devider my-4">
                                            <ul class="list-unstyled pricing-features-list mb-4">
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.unlimited_drivers') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.calculate_unlimited_invoices') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.dashboard_statistics') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.calculate_unlimited_invoices') }}</span>
                                                </li>
                                                {{-- <li>
                                                   <i class="ri-checkbox-circle-fill text-success"></i>
                                                   <span class="fw-medium">{{ __('messages.up_to_10_drivers') }}</span>
                                                </li> --}}
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.supervisor_account') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.custom_invoice') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span class="fw-medium">{{ __('messages.vip_support') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span class="fw-medium">{{ __('messages.first_access') }}</span>
                                                </li>
                                            </ul>
                                            <div class="d-grid mt-auto">
                                                <a href="{{ route('subscriptions.checkout', ['plan' => 'diamond']) }}"
                                                    class="btn btn-lg btn-primary">{{ __('messages.get_started') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Quarterly -->
                        <div class="tab-pane p-0 border-0" id="pricing-quarterly" role="tabpanel">
                            <div class="row g-4">
                                <!-- Individual Plan (Monthly) -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card custom-card dashboard-main-card pricing-card">
                                        <div class="card-body p-4">
                                            <div class="lh-1 mb-3">
                                                <span
                                                    class="avatar avatar-lg avatar-rounded bg-bronze-transparent svg-bronze">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                        height="32" fill="#000000" viewBox="0 0 256 256">
                                                        <path
                                                            d="M230.93,220a8,8,0,0,1-6.93,4H32a8,8,0,0,1-6.92-12c15.23-26.33,38.7-45.21,66.09-54.16a72,72,0,1,1,73.66,0c27.39,8.95,50.86,27.83,66.09,54.16A8,8,0,0,1,230.93,220Z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <h5 class="fw-semibold">Bronze</h5>
                                            <p class="text-muted small">{{ __('messages.bronze_description') }}</p>
                                            <div class="pricing-count my-3">
                                                <div class="d-flex align-items-end gap-1">
                                                    <h2 class="fw-semibold mb-0 lh-1 display-5">$62<span
                                                            class="fs-5">.99</span></h2>
                                                    <span
                                                        class="fs-6 text-muted">{{ __('messages.month_suffix') }}</span>
                                                </div>
                                            </div>
                                            <hr class="section-devider my-4">
                                            <ul class="list-unstyled pricing-features-list mb-4">
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.up_to_10_drivers') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.unlimited_drivers') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.weekly_statistics') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.dashboard_statistics') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.calculate_one_invoice') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.calculate_50_invoices') }}</span>
                                                </li>
                                                {{-- <li>
                                                   <i class="ri-checkbox-circle-fill text-success"></i>
                                                   <span class="fw-medium">{{ __('messages.up_to_10_drivers') }}</span>
                                                </li> --}}
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.supervisor_account') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.custom_invoice') }}</span>
                                                </li>
                                            </ul>
                                            <div class="d-grid mt-auto">
                                                <a href="{{ route('subscriptions.checkout', ['plan' => 'bronze']) }}"
                                                    class="btn btn-lg btn-primary">{{ __('messages.get_started') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Team Plan (Monthly) -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card custom-card dashboard-main-card pricing-card ">
                                        <!-- Recommended -->
                                        <div class="card-body p-4">
                                            {{-- <span
                                                class="badge bg-dark text-white pricing-recommended-badge">Recommended</span> --}}
                                            <div class="lh-1 mb-3">
                                                <span
                                                    class="avatar avatar-lg avatar-rounded bg-gold-transparent svg-gold">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                        height="32" fill="#000000" viewBox="0 0 256 256">
                                                        <path
                                                            d="M164.47,195.63a8,8,0,0,1-6.7,12.37H10.23a8,8,0,0,1-6.7-12.37,95.83,95.83,0,0,1,47.22-37.71,60,60,0,1,1,66.5,0A95.83,95.83,0,0,1,164.47,195.63Zm87.91-.15a95.87,95.87,0,0,0-47.13-37.56A60,60,0,0,0,144.7,54.59a4,4,0,0,0-1.33,6A75.83,75.83,0,0,1,147,150.53a4,4,0,0,0,1.07,5.53,112.32,112.32,0,0,1,29.85,30.83,23.92,23.92,0,0,1,3.65,16.47,4,4,0,0,0,3.95,4.64h60.3a8,8,0,0,0,7.73-5.93A8.22,8.22,0,0,0,252.38,195.48Z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <h5 class="fw-semibold">{{ __('messages.gold') }}</h5>
                                            <p class="text-muted small">{{ __('messages.gold_description') }}</p>
                                            <div class="pricing-count my-3">
                                                <div class="d-flex align-items-end gap-1">
                                                    <h2 class="fw-semibold mb-0 lh-1 display-5">$80<span
                                                            class="fs-5">.99</span></h2>
                                                    <span
                                                        class="fs-6 text-muted">{{ __('messages.month_suffix') }}</span>
                                                </div>
                                            </div>
                                            <hr class="section-devider my-4">
                                            <ul class="list-unstyled pricing-features-list mb-4">
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.up_to_50_drivers') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.unlimited_drivers') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.weekly_statistics') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.dashboard_statistics') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.calculate_one_invoice') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.calculate_unlimited_invoices') }}</span>
                                                </li>
                                                {{-- <li>
                                                   <i class="ri-checkbox-circle-fill text-success"></i>
                                                   <span class="fw-medium">{{ __('messages.up_to_10_drivers') }}</span>
                                                </li> --}}
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.supervisor_account') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.custom_invoice') }}</span>
                                                </li>
                                            </ul>
                                            <div class="d-grid mt-auto">
                                                <a href="{{ route('subscriptions.checkout', ['plan' => 'gold']) }}"
                                                    class="btn btn-lg btn-primary">{{ __('messages.get_started') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Enterprise Plan (Monthly) -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card custom-card dashboard-main-card pricing-card ">
                                        <div class="card-body p-4">
                                            <div class="lh-1 mb-3">
                                                <span
                                                    class="avatar avatar-lg avatar-rounded bg-diamond-transparent svg-diamond">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                        height="32" fill="#000000" viewBox="0 0 256 256">
                                                        <path
                                                            d="M64.12,147.8a4,4,0,0,1-4,4.2H16a8,8,0,0,1-7.8-6.17,8.35,8.35,0,0,1,1.62-6.93A67.79,67.79,0,0,1,37,117.51a40,40,0,1,1,66.46-35.8,3.94,3.94,0,0,1-2.27,4.18A64.08,64.08,0,0,0,64,144C64,145.28,64,146.54,64.12,147.8Zm182-8.91A67.76,67.76,0,0,0,219,117.51a40,40,0,1,0-66.46-35.8,3.94,3.94,0,0,0,2.27,4.18A64.08,64.08,0,0,1,192,144c0,1.28,0,2.54-.12,3.8a4,4,0,0,0,4,4.2H240a8,8,0,0,0,7.8-6.17A8.33,8.33,0,0,0,246.17,138.89Zm-89,43.18a48,48,0,1,0-58.37,0A72.13,72.13,0,0,0,65.07,212,8,8,0,0,0,72,224H184a8,8,0,0,0,6.93-12A72.15,72.15,0,0,0,157.19,182.07Z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <h5 class="fw-semibold">{{ __('messages.diamond') }}</h5>
                                            <p class="text-muted small">{{ __('messages.diamond_description') }}</p>
                                            <div class="pricing-count my-3">
                                                <div class="d-flex align-items-end gap-1">
                                                    <h2 class="fw-semibold mb-0 lh-1 display-5">$116<span
                                                            class="fs-5">.99</span></h2>
                                                    <span
                                                        class="fs-6 text-muted">{{ __('messages.month_suffix') }}</span>
                                                </div>
                                            </div>
                                            <hr class="section-devider my-4">
                                            <ul class="list-unstyled pricing-features-list mb-4">
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.unlimited_drivers') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.calculate_unlimited_invoices') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.dashboard_statistics') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.calculate_unlimited_invoices') }}</span>
                                                </li>
                                                {{-- <li>
                                                   <i class="ri-checkbox-circle-fill text-success"></i>
                                                   <span class="fw-medium">{{ __('messages.up_to_10_drivers') }}</span>
                                                </li> --}}
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.supervisor_account') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.custom_invoice') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span class="fw-medium">{{ __('messages.vip_support') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span class="fw-medium">{{ __('messages.first_access') }}</span>
                                                </li>
                                            </ul>
                                            <div class="d-grid mt-auto">
                                                <a href="{{ route('subscriptions.checkout', ['plan' => 'diamond']) }}"
                                                    class="btn btn-lg btn-primary">{{ __('messages.get_started') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Yearly -->
                        <div class="tab-pane p-0 border-0" id="pricing-yearly" role="tabpanel">
                            <div class="row g-4">
                                <!-- Individual Plan (Monthly) -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card custom-card dashboard-main-card pricing-card">
                                        <div class="card-body p-4">
                                            <div class="lh-1 mb-3">
                                                <span
                                                    class="avatar avatar-lg avatar-rounded bg-bronze-transparent svg-bronze">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                        height="32" fill="#000000" viewBox="0 0 256 256">
                                                        <path
                                                            d="M230.93,220a8,8,0,0,1-6.93,4H32a8,8,0,0,1-6.92-12c15.23-26.33,38.7-45.21,66.09-54.16a72,72,0,1,1,73.66,0c27.39,8.95,50.86,27.83,66.09,54.16A8,8,0,0,1,230.93,220Z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <h5 class="fw-semibold">{{ __('messages.bronze') }}</h5>
                                            <p class="text-muted small">{{ __('messages.bronze_description') }}</p>
                                            <div class="pricing-count my-3">
                                                <div class="d-flex align-items-end gap-1">
                                                    <h2 class="fw-semibold mb-0 lh-1 display-5">$55<span
                                                            class="fs-5">.99</span></h2>
                                                    <span
                                                        class="fs-6 text-muted">{{ __('messages.month_suffix') }}</span>
                                                </div>
                                            </div>
                                            <hr class="section-devider my-4">
                                            <ul class="list-unstyled pricing-features-list mb-4">
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.up_to_10_drivers') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.unlimited_drivers') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.weekly_statistics') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.dashboard_statistics') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.calculate_one_invoice') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.calculate_50_invoices') }}</span>
                                                </li>
                                                {{-- <li>
                                                   <i class="ri-checkbox-circle-fill text-success"></i>
                                                   <span class="fw-medium">{{ __('messages.up_to_10_drivers') }}</span>
                                                </li> --}}
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.supervisor_account') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.custom_invoice') }}</span>
                                                </li>
                                            </ul>
                                            <div class="d-grid mt-auto">
                                                <a href="{{ route('subscriptions.checkout', ['plan' => 'bronze']) }}"
                                                    class="btn btn-lg btn-primary">{{ __('messages.get_started') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Team Plan (Monthly) -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card custom-card dashboard-main-card pricing-card ">
                                        <!-- Recommended -->
                                        <div class="card-body p-4">
                                            {{-- <span
                                                class="badge bg-dark text-white pricing-recommended-badge">Recommended</span> --}}
                                            <div class="lh-1 mb-3">
                                                <span
                                                    class="avatar avatar-lg avatar-rounded bg-gold-transparent svg-gold">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                        height="32" fill="#000000" viewBox="0 0 256 256">
                                                        <path
                                                            d="M164.47,195.63a8,8,0,0,1-6.7,12.37H10.23a8,8,0,0,1-6.7-12.37,95.83,95.83,0,0,1,47.22-37.71,60,60,0,1,1,66.5,0A95.83,95.83,0,0,1,164.47,195.63Zm87.91-.15a95.87,95.87,0,0,0-47.13-37.56A60,60,0,0,0,144.7,54.59a4,4,0,0,0-1.33,6A75.83,75.83,0,0,1,147,150.53a4,4,0,0,0,1.07,5.53,112.32,112.32,0,0,1,29.85,30.83,23.92,23.92,0,0,1,3.65,16.47,4,4,0,0,0,3.95,4.64h60.3a8,8,0,0,0,7.73-5.93A8.22,8.22,0,0,0,252.38,195.48Z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <h5 class="fw-semibold">{{ __('messages.gold') }}</h5>
                                            <p class="text-muted small">{{ __('messages.gold_description') }}</p>
                                            <div class="pricing-count my-3">
                                                <div class="d-flex align-items-end gap-1">
                                                    <h2 class="fw-semibold mb-0 lh-1 display-5">$71<span
                                                            class="fs-5">.99</span></h2>
                                                    <span
                                                        class="fs-6 text-muted">{{ __('messages.month_suffix') }}</span>
                                                </div>
                                            </div>
                                            <hr class="section-devider my-4">
                                            <ul class="list-unstyled pricing-features-list mb-4">
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.up_to_50_drivers') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.unlimited_drivers') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.weekly_statistics') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.dashboard_statistics') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.calculate_one_invoice') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.calculate_unlimited_invoices') }}</span>
                                                </li>
                                                {{-- <li>
                                                   <i class="ri-checkbox-circle-fill text-success"></i>
                                                   <span class="fw-medium">{{ __('messages.up_to_10_drivers') }}</span>
                                                </li> --}}
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.supervisor_account') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-close-circle-fill text-danger"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.custom_invoice') }}</span>
                                                </li>
                                            </ul>
                                            <div class="d-grid mt-auto">
                                                <a href="{{ route('subscriptions.checkout', ['plan' => 'gold']) }}"
                                                    class="btn btn-lg btn-primary">{{ __('messages.get_started') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Enterprise Plan (Monthly) -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card custom-card dashboard-main-card pricing-card ">
                                        <div class="card-body p-4">
                                            <div class="lh-1 mb-3">
                                                <span
                                                    class="avatar avatar-lg avatar-rounded bg-diamond-transparent svg-diamond">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                        height="32" fill="#000000" viewBox="0 0 256 256">
                                                        <path
                                                            d="M64.12,147.8a4,4,0,0,1-4,4.2H16a8,8,0,0,1-7.8-6.17,8.35,8.35,0,0,1,1.62-6.93A67.79,67.79,0,0,1,37,117.51a40,40,0,1,1,66.46-35.8,3.94,3.94,0,0,1-2.27,4.18A64.08,64.08,0,0,0,64,144C64,145.28,64,146.54,64.12,147.8Zm182-8.91A67.76,67.76,0,0,0,219,117.51a40,40,0,1,0-66.46-35.8,3.94,3.94,0,0,0,2.27,4.18A64.08,64.08,0,0,1,192,144c0,1.28,0,2.54-.12,3.8a4,4,0,0,0,4,4.2H240a8,8,0,0,0,7.8-6.17A8.33,8.33,0,0,0,246.17,138.89Zm-89,43.18a48,48,0,1,0-58.37,0A72.13,72.13,0,0,0,65.07,212,8,8,0,0,0,72,224H184a8,8,0,0,0,6.93-12A72.15,72.15,0,0,0,157.19,182.07Z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <h5 class="fw-semibold">{{ __('messages.diamond') }}</h5>
                                            <p class="text-muted small">{{ __('messages.diamond_description') }}</p>
                                            <div class="pricing-count my-3">
                                                <div class="d-flex align-items-end gap-1">
                                                    <h2 class="fw-semibold mb-0 lh-1 display-5">$103<span
                                                            class="fs-5">.99</span></h2>
                                                    <span
                                                        class="fs-6 text-muted">{{ __('messages.month_suffix') }}</span>
                                                </div>
                                            </div>
                                            <hr class="section-devider my-4">
                                            <ul class="list-unstyled pricing-features-list mb-4">
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.unlimited_drivers') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.calculate_unlimited_invoices') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.dashboard_statistics') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.calculate_unlimited_invoices') }}</span>
                                                </li>
                                                {{-- <li>
                                                   <i class="ri-checkbox-circle-fill text-success"></i>
                                                   <span class="fw-medium">{{ __('messages.up_to_10_drivers') }}</span>
                                                </li> --}}
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.supervisor_account') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span
                                                        class="fw-medium">{{ __('messages.custom_invoice') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span class="fw-medium">{{ __('messages.vip_support') }}</span>
                                                </li>
                                                <li>
                                                    <i class="ri-checkbox-circle-fill text-success"></i>
                                                    <span class="fw-medium">{{ __('messages.first_access') }}</span>
                                                </li>
                                            </ul>
                                            <div class="d-grid mt-auto">
                                                <a href="{{ route('subscriptions.checkout', ['plan' => 'diamond']) }}"
                                                    class="btn btn-lg btn-primary">{{ __('messages.get_started') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End:: row-1 -->
        </div>
    </section>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- Simple JS for current year -->
    <script>
        // Placeholder - This script would normally set the current year, but it's removed with the footer
        // document.getElementById('current-year').textContent = new Date().getFullYear();
    </script>
</body>

</html>
