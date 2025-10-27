<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.welcome_to_intelboard') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.0.0/fonts/remixicon.css">
    <link rel="stylesheet" href="{{ asset('build/assets/custom.css') }}">
    <link rel="shortcut icon" href=" {{ asset('build/assets/images/brand-logos/favicon.ico') }} " type="image/x-icon">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing') }}">
                <img src=" {{ asset('build/assets/images/brand-logos/desktop-dark.png') }} " alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="navbar-nav align-items-center gap-3">
                    <a class="nav-link" href="#contactus">{{ __('messages.contact') }}</a>
                    <div class="language-switcher ms-2">
                        <a href="{{ route('set.locale', 'en') }}"
                            class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
                        <a href="{{ route('set.locale', 'fr') }}"
                            class="{{ app()->getLocale() === 'fr' ? 'active' : '' }}">FR</a>
                    </div>
                    @auth
                        <a class="btn btn-light ms-3" href="{{ route('index') }}">
                            <i class="ri-arrow-right-line"></i> {{ __('messages.go_to_dashboard') }}
                        </a>
                    @else
                        <a class="btn btn-light ms-3" href="{{ route('login') }}">
                            <i class="ri-login-circle-line"></i> {{ __('messages.login_button') }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Banner -->
    <section class="landing-banner" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6">
                    <div class="d-inline-flex align-items-center gap-2 badge bg-white text-dark rounded-pill mb-3">
                        <i class="ri-flashlight-fill"></i> {{ __('messages.upload_invoices') }}
                    </div>
                    <h1 class="landing-banner-heading">{{ __('messages.track_key_metrics') }} <br>
                        {{ __('messages.and') ?? 'and' }} <span
                            style="color: #fbbf24;">{{ __('messages.optimize') }}</span>
                        {{ __('messages.your_business') }}</h1>

                    <div class="d-flex gap-3 flex-wrap">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                                <i class="ri-login-circle-line"></i> {{ __('messages.get_started_free') }}
                            </a>
                        @endguest
                        @auth
                            <a href="{{ route('index') }}" class="btn btn-light btn-lg">
                                <i class="ri-arrow-right-line"></i> {{ __('messages.go_to_dashboard') }}
                            </a>
                        @endauth
                        <a href="#service" class="btn btn-outline-light btn-lg">
                            <i class="ri-arrow-down-line"></i> {{ __('messages.learn_more') }}
                        </a>
                    </div>
                </div>
                <div class="col-xl-6 text-center d-none d-xl-block">
                    <div style="font-size: 10rem; opacity: 0.1; color: white;">
                        <i class="ri-dashboard-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Services Section -->
    <section class="section" id="service">
        <div class="container">
            <div class="heading-section">
                <div class="heading-subtitle">{{ __('messages.services') }}</div>
                <div class="heading-title">{{ __('messages.comprehensive_solutions') }}</div>
                <div class="heading-description">{{ __('messages.intelboard_description') }}</div>
            </div>
            <div class="row g-4">
                <div class="col-xl-4 col-md-6">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="lh-1 mb-3">
                                <span class="avatar avatar-md avatar-rounded bg-primary-transparent svg-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                        <rect width="256" height="256" fill="none"></rect>
                                        <path d="M104,208V104H32v96a8,8,0,0,0,8,8H96" opacity="0.2"></path>
                                        <line x1="32" y1="104" x2="224" y2="104" fill="none"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="16"></line>
                                        <line x1="104" y1="104" x2="104" y2="208" fill="none"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="16"></line>
                                        <rect x="32" y="48" width="192" height="160" rx="8"
                                            fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="16"></rect>
                                    </svg>
                                </span>
                            </div>
                            <h5 class="fw-semibold">{{ __('messages.driver_management') }}</h5>
                            <span class="fs-15 text-muted">
                                {{ __('messages.track_driver_info') }} {{ __('messages.set_commission_prices') }}
                                {{ __('messages.view_driver_earnings') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="lh-1 mb-3">
                                <span class="avatar avatar-md avatar-rounded bg-success-transparent svg-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                        <rect width="256" height="256" fill="none"></rect>
                                        <path
                                            d="M227.32,28.68a16,16,0,0,0-22.64,0l-144,144a16,16,0,0,0,0,22.64l22.64,22.64a16,16,0,0,0,22.64,0l144-144a16,16,0,0,0,0-22.64Z"
                                            opacity="0.2"></path>
                                        <polyline points="224 32 224 80 176 80" fill="none" stroke="currentColor"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="16">
                                        </polyline>
                                        <polyline points="32 144 80 192 224 48" fill="none" stroke="currentColor"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="16">
                                        </polyline>
                                    </svg>
                                </span>
                            </div>
                            <h5 class="fw-semibold">{{ __('messages.invoice_payment_management') }}</h5>
                            <span class="fs-15 text-muted">
                                {{ __('messages.upload_process_pdf') }} {{ __('messages.automated_pdf_validation') }}
                                {{ __('messages.generate_reports') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="lh-1 mb-3">
                                <span class="avatar avatar-md avatar-rounded bg-warning-transparent svg-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                        <rect width="256" height="256" fill="none"></rect>
                                        <path
                                            d="M224,56v96a8,8,0,0,1-8,8H136v40a8,8,0,0,1-8,8H32a8,8,0,0,1-8-8V96a8,8,0,0,1,8-8H96V56a8,8,0,0,1,8-8h112A8,8,0,0,1,224,56Z"
                                            opacity="0.2"></path>
                                        <rect x="32" y="96" width="96" height="104" rx="8"
                                            fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="16"></rect>
                                        <rect x="128" y="40" width="96" height="104" rx="8"
                                            fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="16"></rect>
                                    </svg>
                                </span>
                            </div>
                            <h5 class="fw-semibold">{{ __('messages.payment_tracking') }}</h5>
                            <span class="fs-15 text-muted">
                                {{ __('messages.invoice_calculations') }} {{ __('messages.commission_calculations') }}
                                {{ __('messages.payment_status_tracking') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="lh-1 mb-3">
                                <span class="avatar avatar-md avatar-rounded bg-info-transparent svg-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                        <rect width="256" height="256" fill="none"></rect>
                                        <path d="M56,56V200a8,8,0,0,0,8,8H208V64a8,8,0,0,0-8-8H56Z" opacity="0.2">
                                        </path>
                                        <polyline points="56 120 100 80 144 120 188 72" fill="none"
                                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="16"></polyline>
                                        <path
                                            d="M208,32H56a8,8,0,0,0-8,8V200a8,8,0,0,0,8,8H208a8,8,0,0,0,8-8V40A8,8,0,0,0,208,32Z"
                                            fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="16"></path>
                                    </svg>
                                </span>
                            </div>
                            <h5 class="fw-semibold">{{ __('messages.analytics') }}</h5>
                            <span class="fs-15 text-muted">
                                {{ __('messages.invoice_benefits_chart') }} {{ __('messages.weekly_earnings') }}
                                {{ __('messages.interactive_charts') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="lh-1 mb-3">
                                <span class="avatar avatar-md avatar-rounded bg-danger-transparent svg-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                        <rect width="256" height="256" fill="none"></rect>
                                        <path d="M128,224a96,96,0,1,0-96-96A96,96,0,0,0,128,224Z" opacity="0.2">
                                        </path>
                                        <circle cx="128" cy="120" r="16" fill="currentColor"></circle>
                                        <path d="M128,64v40" fill="none" stroke="currentColor"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
                                        <path d="M112,208H144" fill="none" stroke="currentColor"
                                            stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
                                    </svg>
                                </span>
                            </div>
                            <h5 class="fw-semibold">{{ __('messages.multi_language_support') }}</h5>
                            <span class="fs-15 text-muted">
                                {{ __('messages.english_french') }} {{ __('messages.dynamic_switching') }}
                                {{ __('messages.language_saving') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card custom-card">
                        <div class="card-body">
                            <div class="lh-1 mb-3">
                                <span class="avatar avatar-md avatar-rounded bg-secondary-transparent svg-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                        <rect width="256" height="256" fill="none"></rect>
                                        <path
                                            d="M224,56v96a8,8,0,0,1-8,8H136v40a8,8,0,0,1-8,8H32a8,8,0,0,1-8-8V96a8,8,0,0,1,8-8H96V56a8,8,0,0,1,8-8h112A8,8,0,0,1,224,56Z"
                                            opacity="0.2"></path>
                                        <rect x="32" y="96" width="96" height="104" rx="8"
                                            fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="16"></rect>
                                        <rect x="128" y="40" width="96" height="104" rx="8"
                                            fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="16"></rect>
                                    </svg>
                                </span>
                            </div>
                            <h5 class="fw-semibold">{{ __('messages.real_time_monitoring') }}</h5>
                            <span class="fs-15 text-muted">
                                {{ __('messages.monitor_business_metrics') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section section-primary">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="mb-2">{{ __('messages.transform_workflow') }}</h4>
                    <p class="mb-0" style="opacity: 0.9;">{{ __('messages.unlock_features') }}</p>
                </div>
                <div class="col-md-4 text-end">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                            <i class="ri-login-circle-line"></i> {{ __('messages.get_started_free') }}
                        </a>
                    @endguest
                    @auth
                        <a href="{{ route('index') }}" class="btn btn-light btn-lg">
                            <i class="ri-arrow-right-line"></i> {{ __('messages.go_to_dashboard') }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="section" style="background: #f8f9fa;">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6">
                    <div class="stats-point">
                        <h4>12,345</h4>
                        <p class="text-muted">{{ __('messages.customers') }}</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stats-point">
                        <h4>56,789</h4>
                        <p class="text-muted">{{ __('messages.invoices_processed') }}</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stats-point">
                        <h4>1,234</h4>
                        <p class="text-muted">{{ __('messages.drivers') }}</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stats-point">
                        <h4>98%</h4>
                        <p class="text-muted">{{ __('messages.satisfaction_rate') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="section section-primary">
        <div class="container">
            <div class="heading-section">
                <div class="heading-subtitle">{{ __('messages.testimonials') }}</div>
                <div class="heading-title">{{ __('messages.see_what_customers_say') }}</div>
                <div class="heading-description">{{ __('messages.customer_feedback') }}</div>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="testimonial-card primary">
                        <div class="testimonial-rating">
                            <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i
                                class="ri-star-fill"></i><i class="ri-star-fill"></i>
                        </div>
                        <h6 class="mb-2">{{ __('messages.productivity_skyrocketed') }}</h6>
                        <p class="small mb-3">{{ __('messages.productivity_feedback') }}</p>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar avatar-sm"
                                style="background: rgba(255,255,255,0.3); border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                <i class="ri-user-line"></i>
                            </div>
                            <div>
                                <small class="fw-bold">John Smith</small><br>
                                <small>{{ __('messages.senior_developer') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="testimonial-card success">
                        <div class="testimonial-rating">
                            <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i
                                class="ri-star-fill"></i><i class="ri-star-fill"></i>
                        </div>
                        <h6 class="mb-2">{{ __('messages.game_changer') }}</h6>
                        <p class="small mb-3">{{ __('messages.game_changer_feedback') }}</p>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar avatar-sm"
                                style="background: rgba(255,255,255,0.3); border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                <i class="ri-user-line"></i>
                            </div>
                            <div>
                                <small class="fw-bold">Emily Johnson</small><br>
                                <small>{{ __('messages.product_manager') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="testimonial-card warning">
                        <div class="testimonial-rating">
                            <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i
                                class="ri-star-fill"></i><i class="ri-star-fill"></i>
                        </div>
                        <h6 class="mb-2">{{ __('messages.simple_powerful') }}</h6>
                        <p class="small mb-3">{{ __('messages.simple_feedback') }}</p>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar avatar-sm"
                                style="background: rgba(255,255,255,0.3); border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                                <i class="ri-user-line"></i>
                            </div>
                            <div>
                                <small class="fw-bold">Sarah Davis</small><br>
                                <small>{{ __('messages.marketing_specialist') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section" id="contactus">
        <div class="container">
            <div class="heading-section">
                <div class="heading-subtitle">{{ __('messages.contact') }}</div>
                <div class="heading-title">{{ __('messages.get_in_touch') }}</div>
                <div class="heading-description">{{ __('messages.get_in_touch_description') }}</div>
            </div>
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="contact-form">
                        <h6 class="mb-4">{{ __('messages.get_in_touch_form') }}</h6>
                        <form>
                            <div class="row g-3">
                                <div class="col-6">
                                    <input type="text" class="form-control"
                                        placeholder="{{ __('messages.first_name') }}">
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control"
                                        placeholder="{{ __('messages.last_name') }}">
                                </div>
                                <div class="col-12">
                                    <input type="email" class="form-control"
                                        placeholder="{{ __('messages.email_address') }}">
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control"
                                        placeholder="{{ __('messages.phone_number') }}">
                                </div>
                                <div class="col-12">
                                    <textarea class="form-control" rows="4" placeholder="{{ __('messages.your_message') }}"></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary-gradient btn-lg w-100">
                                        {{ __('messages.submit') }} <i class="ri-arrow-right-line ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="contact-info">
                                <div class="icon"><i class="ri-map-pin-line"></i></div>
                                <h6 class="fw-bold">{{ __('messages.address') }}</h6>
                                <p class="text-muted">{{ __('messages.business_address') }}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="contact-info">
                                <div class="icon"><i class="ri-phone-line"></i></div>
                                <h6 class="fw-bold">{{ __('messages.phone') }}</h6>
                                <p class="text-muted">{{ __('messages.business_phone') }}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="contact-info">
                                <div class="icon"><i class="ri-mail-line"></i></div>
                                <h6 class="fw-bold">{{ __('messages.email') }}</h6>
                                <p class="text-muted">{{ __('messages.business_email') }}</p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="contact-info">
                                <div class="icon"><i class="ri-time-line"></i></div>
                                <h6 class="fw-bold">{{ __('messages.business_hours') }}</h6>
                                <p class="text-muted">{{ __('messages.hours_text') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="section bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 class="display-5 fw-bold mb-3">{{ __('messages.build_manage') }}</h2>
                    <p class="lead text-muted">{{ __('messages.build_manage_description') }}</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('index') }}" class="btn btn-primary-gradient btn-lg">
                        {{ __('messages.get_started_free') }} <i class="ri-arrow-right-line ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3">Intelboard</h5>
                    <p class="text-muted">{{ __('messages.footer_tagline') }}</p>
                </div>
                <div class="col-lg-2">
                    <h6 class="fw-bold mb-3">{{ __('messages.product') }}</h6>
                    <ul class="list-unstyled">
                        <li><a href="#"
                                class="text-muted text-decoration-none">{{ __('messages.features') }}</a></li>
                        <li><a href="#"
                                class="text-muted text-decoration-none">{{ __('messages.pricing') }}</a></li>
                        <li><a href="#"
                                class="text-muted text-decoration-none">{{ __('messages.security') }}</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h6 class="fw-bold mb-3">{{ __('messages.company') }}</h6>
                    <ul class="list-unstyled">
                        <li><a href="#"
                                class="text-muted text-decoration-none">{{ __('messages.about_us') }}</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">{{ __('messages.blog') }}</a>
                        </li>
                        <li><a href="#"
                                class="text-muted text-decoration-none">{{ __('messages.careers') }}</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold mb-3">{{ __('messages.follow_us') }}</h6>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-muted"><i class="ri-facebook-fill"></i></a>
                        <a href="#" class="text-muted"><i class="ri-twitter-fill"></i></a>
                        <a href="#" class="text-muted"><i class="ri-linkedin-fill"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-md-6">
                    <p class="text-muted text-sm">{{ __('messages.footer_copyright') }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted text-sm">
                        <a href="#"
                            class="text-muted text-decoration-none">{{ __('messages.privacy_policy') }}</a> •
                        <a href="#"
                            class="text-muted text-decoration-none">{{ __('messages.terms_of_service') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
