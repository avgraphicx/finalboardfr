@extends('layouts.custom-master')

@section('styles')
    <style>
        .dashboard-banner-image {
            position: absolute;
            bottom: 0;
            top: 1em;
            right: 15px;
        }

        .fs-20 {
            font-size: 20px;
        }

        .landing-lang-switcher {
            /* display: inline-flex;
                align-items: center;
                gap: 0.35rem; */
            text-transform: uppercase;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .landing-lang-switcher img {
            width: 24px;
            height: 24px;
            /* border-radius: 50%; */
            object-fit: cover;
        }
    </style>
    </style>
@endsection

@section('content')
    @php
        $currentLocale = Session::get('locale', 'en');
        $switchLocale = $currentLocale === 'fr' ? 'en' : 'fr';
        $switchFlag = $switchLocale === 'fr'
            ? asset('build/assets/images/flags/french_flag.jpg')
            : asset('build/assets/images/flags/us_flag.jpg');
        $currentFlag = $currentLocale === 'fr'
            ? asset('build/assets/images/flags/french_flag.jpg')
            : asset('build/assets/images/flags/us_flag.jpg');
        $priceMap = config('services.stripe.prices', []);
        $priceForPlan = static function (string $plan, string $interval) use ($priceMap) {
            return data_get($priceMap, "{$plan}.{$interval}") ?? data_get($priceMap, "{$plan}.monthly");
        };
    @endphp
    <div class="row text-center mt-3">
        <a class="landing-lang-switcher nav-link p-0 me-2" href="{{ route('set.locale', $switchLocale) }}"
            data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ __('messages.switch_language') }}">
            <img src="{{ $currentFlag }}" alt="{{ strtoupper($currentLocale) }} Flag">
            <span>{{ strtoupper($currentLocale) }}</span>
        </a>
    </div>
    <div class="row justify-content-center my-3 p-4" id="sub-alert">
        <div class="col-lg-9 col-md-12 col-sm-12">

            <div class="alert alert-solid-primary alert-dismissible fade show text-center">
                <p class="fw-medium fs-20">
                    {{ __('messages.no_active_subscription') }}
                </p>
                <p class="fs-14 op-8 mb-1">{{ __('messages.choose_plan_to_continue') }}</p>
                <p class="fs-12 d-inline-flex">
                    {{ __('messages.select_plan_below') }}
                </p>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i
                        class="bi bi-x"></i></button>
            </div>
        </div>
    </div>

    <!-- Start::Pricing Section -->
    <section id="pricing" class="section-padding">
        <div class="container">
            <!-- Start:: row-1 -->
            <div class="row d-flex justify-content-center">
                <div class="pricing-heading-section text-center mb-5">
                    <span class="badge bg-primary-transparent rounded-pill">
                        {{ __('messages.pricing_plans') }}
                    </span>
                    <h2 class="fw-semibold mt-3 section-title">{{ __('messages.choose_right_plan') }}</h2>
                    <span class="d-block text-muted fs-16 mb-3">{{ __('messages.choose_plan_desc') }}</span>
                    <div class="tab-style-1 border p-1 bg-white rounded-pill d-inline-block">
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link rounded-pill fw-medium active" data-bs-toggle="pill"
                                    data-bs-target="#pricing-monthly" aria-selected="true"
                                    role="tab">{{ __('messages.monthly') }}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link rounded-pill fw-medium" data-bs-toggle="pill"
                                    data-bs-target="#pricing-semiannually" aria-selected="false" role="tab"
                                    tabindex="-1">{{ __('messages.semiannually') }} <span
                                        class="badge bg-success-transparent text-warning ms-1">{{ __('messages.save_10') }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link rounded-pill fw-medium" data-bs-toggle="pill"
                                    data-bs-target="#pricing-yearly" aria-selected="false" role="tab"
                                    tabindex="-1">{{ __('messages.yearly') }} <span
                                        class="badge bg-success-transparent text-success ms-1">{{ __('messages.save_20') }}</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="tab-content">
                        <!-- Monthly -->
                        <div class="tab-pane show active p-0 border-0" id="pricing-monthly" role="tabpanel">
                            <div class="row g-4">
                                <!-- Bronze Plan (Monthly) -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card custom-card dashboard-main-card pricing-card">
                                        <div class="card-body p-4">
                                            <h5 class="fw-semibold">{{ __('messages.bronze') }}</h5>
                                            <p class="text-muted small">{{ __('messages.bronze_desc') }}</p>
                                            <div class="pricing-count my-3">
                                                <div class="d-flex align-items-end gap-1">
                                                    <h2 class="fw-semibold mb-0 lh-1 display-5">$69<span
                                                            class="fs-5">.99</span></h2>
                                                    <span class="fs-6 text-muted">{{ __('messages.per_month') }}</span>
                                                </div>
                                            </div>
                                            <hr class="section-devider my-4">
                                            <ul class="list-unstyled pricing-features-list mb-4">
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.add_up_to_10_drivers') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.add_unlimited_drivers') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.view_weekly_stats') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.choose_daily_weekly_monthly') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.auto_calculate_invoice') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.auto_calculate_multiple') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.add_supervisor_account') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.create_custom_invoice') }}</span>
                                                </li>
                                            </ul>
                                            <div class="d-grid mt-auto">
                                                <a href="{{ route('subscribe.view', ['price_id' => $priceForPlan('bronze', 'monthly')]) }}"
                                                    class="btn btn-lg btn-primary">{{ __('messages.get_started') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Gold Plan (Monthly) -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card custom-card dashboard-main-card pricing-card">
                                        <div class="card-body p-4">
                                            <h5 class="fw-semibold">{{ __('messages.gold') }}</h5>
                                            <p class="text-muted small">{{ __('messages.gold_desc') }}</p>
                                            <div class="pricing-count my-3">
                                                <div class="d-flex align-items-end gap-1">
                                                    <h2 class="fw-semibold mb-0 lh-1 display-5">$89<span
                                                            class="fs-5">.99</span></h2>
                                                    <span class="fs-6 text-muted">{{ __('messages.per_month') }}</span>
                                                </div>
                                            </div>
                                            <hr class="section-devider my-4">
                                            <ul class="list-unstyled pricing-features-list mb-4">
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.add_up_to_50_drivers') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.add_unlimited_drivers') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.view_weekly_stats') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.choose_daily_weekly_monthly') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.auto_calculate_invoice') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.auto_calculate_up_to_10') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.add_supervisor_account') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.create_custom_invoice') }}</span>
                                                </li>
                                            </ul>
                                            <div class="d-grid mt-auto">
                                                <a href="{{ route('subscribe.view', ['price_id' => $priceForPlan('gold', 'monthly')]) }}"
                                                    class="btn btn-lg btn-primary">{{ __('messages.get_started') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Diamond Plan (Monthly) -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card custom-card dashboard-main-card pricing-card">
                                        <div class="card-body p-4">
                                            <h5 class="fw-semibold">{{ __('messages.diamond') }}</h5>
                                            <p class="text-muted small">{{ __('messages.diamond_desc') }}</p>
                                            <div class="pricing-count my-3">
                                                <div class="d-flex align-items-end gap-1">
                                                    <h2 class="fw-semibold mb-0 lh-1 display-5">$129<span
                                                            class="fs-5">.99</span></h2>
                                                    <span class="fs-6 text-muted">{{ __('messages.per_month') }}</span>
                                                </div>
                                            </div>
                                            <hr class="section-devider my-4">
                                            <ul class="list-unstyled pricing-features-list mb-4">
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.add_unlimited_drivers') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.view_stats_dashboard') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.choose_daily_weekly_monthly') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.auto_calculate_unlimited') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.add_supervisor_account') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.create_custom_invoice') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.vip_support') }}</span></li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.first_access_features') }}</span>
                                                </li>
                                            </ul>
                                            <div class="d-grid mt-auto">
                                                <a href="{{ route('subscribe.view', ['price_id' => $priceForPlan('diamond', 'monthly')]) }}"
                                                    class="btn btn-lg btn-primary">{{ __('messages.get_started') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- semiannually -->
                        <div class="tab-pane p-0 border-0" id="pricing-semiannually" role="tabpanel">
                            <div class="row g-4">
                                <!-- Bronze Plan (semiannually) -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card custom-card dashboard-main-card pricing-card">
                                        <div class="card-body p-4">
                                            <h5 class="fw-semibold">{{ __('messages.bronze') }}</h5>
                                            <p class="text-muted small">{{ __('messages.bronze_desc') }}</p>
                                            <div class="pricing-count my-3">
                                                <div class="d-flex align-items-end gap-1">
                                                    <h2 class="fw-semibold mb-0 lh-1 display-5">$62<span
                                                            class="fs-5">.99</span></h2>
                                                    <span class="fs-6 text-muted">{{ __('messages.per_month') }}</span>
                                                </div>
                                            </div>
                                            <hr class="section-devider my-4">
                                            <ul class="list-unstyled pricing-features-list mb-4">
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.add_up_to_10_drivers') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.add_unlimited_drivers') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.view_weekly_stats') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.choose_daily_weekly_monthly') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.auto_calculate_invoice') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.auto_calculate_multiple') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.add_supervisor_account') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.create_custom_invoice') }}</span>
                                                </li>
                                            </ul>
                                            <div class="d-grid mt-auto">
                                                <a href="{{ route('subscribe.view', ['price_id' => $priceForPlan('bronze', 'semiannually')]) }}"
                                                    class="btn btn-lg btn-primary">{{ __('messages.get_started') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Gold Plan (semiannually) -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card custom-card dashboard-main-card pricing-card">
                                        <div class="card-body p-4">
                                            <h5 class="fw-semibold">{{ __('messages.gold') }}</h5>
                                            <p class="text-muted small">{{ __('messages.gold_desc') }}</p>
                                            <div class="pricing-count my-3">
                                                <div class="d-flex align-items-end gap-1">
                                                    <h2 class="fw-semibold mb-0 lh-1 display-5">$80<span
                                                            class="fs-5">.99</span></h2>
                                                    <span class="fs-6 text-muted">{{ __('messages.per_month') }}</span>
                                                </div>
                                            </div>
                                            <hr class="section-devider my-4">
                                            <ul class="list-unstyled pricing-features-list mb-4">
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.add_up_to_50_drivers') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.add_unlimited_drivers') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.view_weekly_stats') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.choose_daily_weekly_monthly') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.auto_calculate_invoice') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.auto_calculate_up_to_10') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.add_supervisor_account') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.create_custom_invoice') }}</span>
                                                </li>
                                            </ul>
                                            <div class="d-grid mt-auto">
                                                <a href="{{ route('subscribe.view', ['price_id' => $priceForPlan('gold', 'semiannually')]) }}"
                                                    class="btn btn-lg btn-primary">{{ __('messages.get_started') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Diamond Plan (semiannually) -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card custom-card dashboard-main-card pricing-card">
                                        <div class="card-body p-4">
                                            <h5 class="fw-semibold">{{ __('messages.diamond') }}</h5>
                                            <p class="text-muted small">{{ __('messages.diamond_desc') }}</p>
                                            <div class="pricing-count my-3">
                                                <div class="d-flex align-items-end gap-1">
                                                    <h2 class="fw-semibold mb-0 lh-1 display-5">$116<span
                                                            class="fs-5">.99</span></h2>
                                                    <span class="fs-6 text-muted">{{ __('messages.per_month') }}</span>
                                                </div>
                                            </div>
                                            <hr class="section-devider my-4">
                                            <ul class="list-unstyled pricing-features-list mb-4">
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.add_unlimited_drivers') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.view_stats_dashboard') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.choose_daily_weekly_monthly') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.auto_calculate_unlimited') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.add_supervisor_account') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.create_custom_invoice') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.vip_support') }}</span></li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.first_access_features') }}</span>
                                                </li>
                                            </ul>
                                            <div class="d-grid mt-auto">
                                                <a href="{{ route('subscribe.view', ['price_id' => $priceForPlan('diamond', 'semiannually')]) }}"
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
                                <!-- Bronze Plan (Yearly) -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card custom-card dashboard-main-card pricing-card">
                                        <div class="card-body p-4">
                                            <h5 class="fw-semibold">{{ __('messages.bronze') }}</h5>
                                            <p class="text-muted small">{{ __('messages.bronze_desc') }}</p>
                                            <div class="pricing-count my-3">
                                                <div class="d-flex align-items-end gap-1">
                                                    <h2 class="fw-semibold mb-0 lh-1 display-5">$55<span
                                                            class="fs-5">.99</span></h2>
                                                    <span class="fs-6 text-muted">{{ __('messages.per_month') }}</span>
                                                </div>
                                            </div>
                                            <hr class="section-devider my-4">
                                            <ul class="list-unstyled pricing-features-list mb-4">
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.add_up_to_10_drivers') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.add_unlimited_drivers') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.view_weekly_stats') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.choose_daily_weekly_monthly') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.auto_calculate_invoice') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.auto_calculate_multiple') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.add_supervisor_account') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.create_custom_invoice') }}</span>
                                                </li>
                                            </ul>
                                            <div class="d-grid mt-auto">
                                                <a href="{{ route('subscribe.view', ['price_id' => $priceForPlan('bronze', 'yearly')]) }}"
                                                    class="btn btn-lg btn-primary">{{ __('messages.get_started') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Gold Plan (Yearly) -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card custom-card dashboard-main-card pricing-card">
                                        <div class="card-body p-4">
                                            <h5 class="fw-semibold">{{ __('messages.gold') }}</h5>
                                            <p class="text-muted small">{{ __('messages.gold_desc') }}</p>
                                            <div class="pricing-count my-3">
                                                <div class="d-flex align-items-end gap-1">
                                                    <h2 class="fw-semibold mb-0 lh-1 display-5">$71<span
                                                            class="fs-5">.99</span></h2>
                                                    <span class="fs-6 text-muted">{{ __('messages.per_month') }}</span>
                                                </div>
                                            </div>
                                            <hr class="section-devider my-4">
                                            <ul class="list-unstyled pricing-features-list mb-4">
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.add_up_to_50_drivers') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.add_unlimited_drivers') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.view_weekly_stats') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.choose_daily_weekly_monthly') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.auto_calculate_invoice') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.auto_calculate_up_to_10') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.add_supervisor_account') }}</span>
                                                </li>
                                                <li><i class="ri-close-circle-fill text-danger"></i> <span
                                                        class="fw-medium">{{ __('messages.create_custom_invoice') }}</span>
                                                </li>
                                            </ul>
                                            <div class="d-grid mt-auto">
                                                <a href="{{ route('subscribe.view', ['price_id' => $priceForPlan('gold', 'yearly')]) }}"
                                                    class="btn btn-lg btn-primary">{{ __('messages.get_started') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Diamond Plan (Yearly) -->
                                <div class="col-lg-4 col-md-6">
                                    <div class="card custom-card dashboard-main-card pricing-card">
                                        <div class="card-body p-4">
                                            <h5 class="fw-semibold">{{ __('messages.diamond') }}</h5>
                                            <p class="text-muted small">{{ __('messages.diamond_desc') }}</p>
                                            <div class="pricing-count my-3">
                                                <div class="d-flex align-items-end gap-1">
                                                    <h2 class="fw-semibold mb-0 lh-1 display-5">$103<span
                                                            class="fs-5">.99</span></h2>
                                                    <span class="fs-6 text-muted">{{ __('messages.per_month') }}</span>
                                                </div>
                                            </div>
                                            <hr class="section-devider my-4">
                                            <ul class="list-unstyled pricing-features-list mb-4">
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.add_unlimited_drivers') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.view_stats_dashboard') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.choose_daily_weekly_monthly') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.auto_calculate_unlimited') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.add_supervisor_account') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.create_custom_invoice') }}</span>
                                                </li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.vip_support') }}</span></li>
                                                <li><i class="ri-checkbox-circle-fill text-success"></i> <span
                                                        class="fw-medium">{{ __('messages.first_access_features') }}</span>
                                                </li>
                                            </ul>
                                            <div class="d-grid mt-auto">
                                                <a href="{{ route('subscribe.view', ['price_id' => $priceForPlan('diamond', 'yearly')]) }}"
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
        </div>
    </section>
    <!-- End::Pricing Section -->
@endsection

@section('scripts')
@endsection
