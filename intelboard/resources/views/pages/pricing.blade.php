@extends('layouts.custom-master')

@section('content')
    <div class="container mt-5">
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
                                    <button type="button" class="nav-link rounded-pill fw-medium active"
                                        data-bs-toggle="pill" data-bs-target="#pricing-monthly" aria-selected="true"
                                        role="tab">{{ __('messages.monthly') }}
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button type="button" class="nav-link rounded-pill fw-medium" data-bs-toggle="pill"
                                        data-bs-target="#pricing-quarterly" aria-selected="false" role="tab"
                                        tabindex="-1">{{ __('messages.quarterly') }} <span
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
                                                {{-- Plan details --}}
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
                                                    {{-- Features --}}
                                                </ul>
                                                <div class="d-grid mt-auto">
                                                    <a href="{{ route('subscribe.view', ['price_id' => 'YOUR_BRONZE_MONTHLY_PRICE_ID']) }}"
                                                        class="btn btn-lg btn-primary">{{ __('messages.get_started') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Gold Plan (Monthly) -->
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card custom-card dashboard-main-card pricing-card">
                                            <div class="card-body p-4">
                                                {{-- Plan details --}}
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
                                                    {{-- Features --}}
                                                </ul>
                                                <div class="d-grid mt-auto">
                                                    <a href="{{ route('subscribe.view', ['price_id' => 'YOUR_GOLD_MONTHLY_PRICE_ID']) }}"
                                                        class="btn btn-lg btn-primary">{{ __('messages.get_started') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Diamond Plan (Monthly) -->
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card custom-card dashboard-main-card pricing-card">
                                            <div class="card-body p-4">
                                                {{-- Plan details --}}
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
                                                    {{-- Features --}}
                                                </ul>
                                                <div class="d-grid mt-auto">
                                                    <a href="{{ route('subscribe.view', ['price_id' => 'YOUR_DIAMOND_MONTHLY_PRICE_ID']) }}"
                                                        class="btn btn-lg btn-primary">{{ __('messages.get_started') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Quarterly -->
                            <div class="tab-pane p-0 border-0" id="pricing-quarterly" role="tabpanel">
                                {{-- Quarterly plans here --}}
                            </div>
                            <!-- Yearly -->
                            <div class="tab-pane p-0 border-0" id="pricing-yearly" role="tabpanel">
                                {{-- Yearly plans here --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
