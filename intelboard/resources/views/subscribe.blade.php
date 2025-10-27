<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.checkout_page_title') }} - Intelboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="{{ asset('build/assets/landing.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: #f8fafc;
        }

        .checkout-hero {
            padding: 4rem 0 2rem;
        }

        .plan-card {
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            padding: 1.5rem;
            background: #fff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }

        .plan-card.active {
            border-color: #0d6efd;
            box-shadow: 0 12px 36px rgba(13, 110, 253, 0.15);
        }

        .plan-features li {
            margin-bottom: 0.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .plan-features i {
            color: #0d6efd;
            margin-top: 0.2rem;
        }

        .plan-switcher .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .plan-switcher .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.12);
        }

        .checkout-form .form-control,
        .checkout-form .form-select {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
        }

        .checkout-form label {
            font-weight: 600;
            color: #0f172a;
        }

        .alert-status {
            border-radius: 0.75rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('landing') }}">{{ __('messages.intelboard') }}</a>
            <a class="btn btn-outline-primary btn-sm" href="{{ route('landing') }}">
                {{ __('messages.checkout_back_to_landing') }}
            </a>
        </div>
    </nav>

    <section class="checkout-hero">
        <div class="container">
            <div class="row justify-content-between align-items-start gy-4">
                <div class="col-lg-6">
                    <h1 class="display-5 fw-semibold text-dark">{{ __('messages.checkout_page_title') }}</h1>
                    <p class="lead text-muted mt-3">{{ __('messages.checkout_page_description') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4 pb-6">
        <div class="container">
            @if (session('status'))
                <div class="alert alert-success alert-status mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
                </div>
            @endif

            <div class="row gy-4">
                <div class="col-lg-4">
                    <div class="plan-card active h-100">
                        <span class="text-uppercase small fw-bold text-primary">{{ __('messages.checkout_selected_plan') }}</span>
                        <h2 class="h3 mt-2">{{ $selectedPlan->name }}</h2>
                        <p class="text-muted">{{ __('messages.checkout_plan_summary') }}</p>

                        <div class="d-flex align-items-baseline gap-2 mt-3">
                            <span class="h2 fw-semibold text-dark">
                                @if ($selectedPlan->formatted_price)
                                    ${{ $selectedPlan->formatted_price }}
                                @else
                                    {{ __('messages.checkout_price_contact') }}
                                @endif
                            </span>
                            @if ($selectedPlan->formatted_price)
                                <span class="text-muted">{{ __('messages.month_suffix') }}</span>
                            @endif
                        </div>

                        <hr class="my-4">

                        <h3 class="h6 text-uppercase fw-bold text-primary">{{ __('messages.checkout_features') }}</h3>
                        <ul class="list-unstyled plan-features mt-3">
                            @foreach ($selectedPlan->feature_list as $feature)
                                <li>
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <hr class="my-4">
                        <h3 class="h6 fw-semibold text-muted mb-3">{{ __('messages.checkout_switch_plan') }}</h3>
                        <div class="plan-switcher">
                            @foreach ($plans as $plan)
                                @continue($plan->id === $selectedPlan->id)
                                <div class="card border-0 shadow-sm mb-3">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <h4 class="h6 fw-semibold mb-1">{{ $plan->name }}</h4>
                                                <p class="mb-0 text-muted">
                                                    @if ($plan->formatted_price)
                                                        ${{ $plan->formatted_price }} {{ __('messages.month_suffix') }}
                                                    @else
                                                        {{ __('messages.checkout_price_contact') }}
                                                    @endif
                                                </p>
                                            </div>
                                            <a href="{{ route('subscriptions.checkout', ['plan' => $plan->slug]) }}"
                                                class="btn btn-outline-primary btn-sm">
                                                {{ __('messages.checkout_plan_button') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="plan-card checkout-form">
                        <h2 class="h4 fw-semibold mb-3">{{ __('messages.checkout_form_title') }}</h2>
                        <form method="POST" action="{{ route('subscriptions.checkout.store') }}" novalidate>
                            @csrf
                            <input type="hidden" name="plan" value="{{ $selectedPlan->slug }}">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="lead-name">{{ __('messages.checkout_name_label') }}</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="lead-name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="lead-email">{{ __('messages.checkout_email_label') }}</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="lead-email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="lead-company">{{ __('messages.checkout_company_label') }}</label>
                                    <input type="text" class="form-control @error('company') is-invalid @enderror"
                                        id="lead-company" name="company" value="{{ old('company') }}">
                                    @error('company')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="lead-phone">{{ __('messages.checkout_phone_label') }}</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="lead-phone" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="form-label"
                                        for="lead-message">{{ __('messages.checkout_message_label') }}</label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" id="lead-message" name="message"
                                        rows="4">{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    {{ __('messages.checkout_submit') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-4 bg-white border-top">
        <div class="container text-center text-muted">
            <small>{{ __('messages.footer_copyright') }}</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
</body>

</html>
