@extends('layouts.custom-master')

@section('styles')
    <style>
        .subscription-page {
            max-width: 1080px;
            margin: 0 auto;
        }

        .subscription-shell {
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.12);
            padding: 2.5rem;
        }

        .subscription-shell__header {
            border-bottom: 1px solid rgba(15, 23, 42, 0.08);
            padding-bottom: 1.5rem;
            margin-bottom: 2rem;
        }

        .subscription-brand {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        .subscription-logo {
            height: 46px;
        }

        .subscription-language {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            border: 1px solid rgba(15, 23, 42, 0.08);
            text-transform: uppercase;
            font-weight: 600;
            font-size: 0.85rem;
            color: inherit;
        }

        .subscription-language img {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            object-fit: cover;
        }

        .stripe-field {
            display: block;
            min-height: 52px;
            padding: 0.75rem 1rem;
            border: 1px solid #d0d5dd;
            border-radius: 0.75rem;
            background: #ffffff;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .stripe-field:focus-within,
        .stripe-field.is-focused {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
        }

        .stripe-field .StripeElement {
            width: 100%;
            font-size: 0.95rem;
            color: #111827;
        }

        .stripe-field .__PrivateStripeElement {
            height: 100%;
        }

        .stripe-field.has-error {
            border-color: #dc2626;
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.12);
        }

        .summary-card .plan-title {
            font-size: 1.1rem;
        }

        .summary-card .plan-price {
            font-size: 1.75rem;
        }

        .summary-card ul {
            margin-bottom: 0;
        }
    </style>
@endsection

@section('content')
    @php
        $priceCatalog = config('services.stripe.prices', []);

        $planCatalog = [
            'bronze' => [
                'label' => __('messages.bronze'),
                'description' => __('messages.bronze_desc'),
                'features' => [
                    __('messages.add_up_to_10_drivers'),
                    __('messages.view_weekly_stats'),
                    __('messages.auto_calculate_invoice'),
                ],
                'pricing' => [
                    'monthly' => ['monthly_price' => 69.99, 'multiplier' => 1],
                    'semiannually' => ['monthly_price' => 62.99, 'multiplier' => 6],
                    'yearly' => ['monthly_price' => 55.99, 'multiplier' => 12],
                ],
            ],
            'gold' => [
                'label' => __('messages.gold'),
                'description' => __('messages.gold_desc'),
                'features' => [
                    __('messages.add_up_to_50_drivers'),
                    __('messages.view_weekly_stats'),
                    __('messages.choose_daily_weekly_monthly'),
                    __('messages.auto_calculate_invoice'),
                ],
                'pricing' => [
                    'monthly' => ['monthly_price' => 89.99, 'multiplier' => 1],
                    'semiannually' => ['monthly_price' => 80.99, 'multiplier' => 6],
                    'yearly' => ['monthly_price' => 71.99, 'multiplier' => 12],
                ],
            ],
            'diamond' => [
                'label' => __('messages.diamond'),
                'description' => __('messages.diamond_desc'),
                'features' => [
                    __('messages.add_unlimited_drivers'),
                    __('messages.view_stats_dashboard'),
                    __('messages.auto_calculate_unlimited'),
                    __('messages.create_custom_invoice'),
                ],
                'pricing' => [
                    'monthly' => ['monthly_price' => 129.99, 'multiplier' => 1],
                    'semiannually' => ['monthly_price' => 116.99, 'multiplier' => 6],
                    'yearly' => ['monthly_price' => 103.99, 'multiplier' => 12],
                ],
            ],
        ];

        $intervalLabels = [
            'monthly' => __('messages.monthly'),
            'semiannually' => __('messages.semiannually'),
            'quarterly' => __('messages.quarterly'),
            'yearly' => __('messages.yearly'),
        ];

        $selectedPlanKey = 'bronze';
        $selectedIntervalKey = 'monthly';

        foreach ($priceCatalog as $planKey => $intervals) {
            foreach ($intervals as $intervalKey => $stripePriceId) {
                if ($stripePriceId === $price_id) {
                    $selectedPlanKey = $planKey;
                    $selectedIntervalKey = $intervalKey;
                    break 2;
                }
            }
        }

        $selectedPlanData = $planCatalog[$selectedPlanKey] ?? reset($planCatalog);
        $selectedPricing = $selectedPlanData['pricing'][$selectedIntervalKey] ?? $selectedPlanData['pricing']['monthly'];

        $perMonthPrice = $selectedPricing['monthly_price'] ?? null;
        $billingMultiplier = $selectedPricing['multiplier'] ?? 1;
        $totalDue = $perMonthPrice !== null ? round($perMonthPrice * $billingMultiplier, 2) : null;

        $perMonthDisplay = $perMonthPrice !== null ? '$' . number_format($perMonthPrice, 2) : '—';
        $totalDueDisplay = $totalDue !== null ? '$' . number_format($totalDue, 2) : $perMonthDisplay;

        $intervalLabel = $intervalLabels[$selectedIntervalKey] ?? ucfirst($selectedIntervalKey);
        $planInitial = strtoupper(mb_substr($selectedPlanData['label'] ?? 'I', 0, 1));
        $features = $selectedPlanData['features'] ?? [];

        $gstAmount = $totalDue !== null ? round($totalDue * 0.05, 2) : null;
        $qstAmount = $totalDue !== null ? round($totalDue * 0.09975, 2) : null;
        $grandTotal = $totalDue !== null ? round($totalDue + $gstAmount + $qstAmount, 2) : null;

        $gstDisplay = $gstAmount !== null ? '$' . number_format($gstAmount, 2) : '—';
        $qstDisplay = $qstAmount !== null ? '$' . number_format($qstAmount, 2) : '—';
        $grandTotalDisplay = $grandTotal !== null ? '$' . number_format($grandTotal, 2) : $totalDueDisplay;

        $currentLocale = Session::get('locale', app()->getLocale());
        $switchLocale = $currentLocale === 'fr' ? 'en' : 'fr';
        $currentFlag = $currentLocale === 'fr'
            ? asset('build/assets/images/flags/french_flag.jpg')
            : asset('build/assets/images/flags/us_flag.jpg');

        $billingDescriptor = match ($selectedIntervalKey) {
            'monthly' => __('messages.billed_monthly') ?? 'Billed monthly',
            'quarterly' => __('messages.billed_quarterly') ?? 'Billed quarterly',
            'semiannually' => __('messages.billed_semiannually') ?? 'Billed every 6 months',
            'yearly' => __('messages.billed_annually') ?? 'Billed yearly',
            default => __('messages.billing_cycle', ['interval' => $selectedIntervalKey]) ?? ('Billed ' . $selectedIntervalKey),
        };
    @endphp

    <div class="subscription-page">
        <div class="subscription-shell">
            <div class="subscription-shell__header d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="subscription-brand">
                    <img src="{{ asset('build/assets/images/brand-logos/desktop-logo.png') }}" alt="Intelboard logo"
                        class="subscription-logo">
                    <span class="fw-semibold">{{ __('messages.subscription') ?? 'Subscription' }}</span>
                </div>
                <a class="subscription-language" href="{{ route('set.locale', $switchLocale) }}"
                    title="{{ __('messages.switch_language') }}">
                    <img src="{{ $currentFlag }}" alt="{{ strtoupper($currentLocale) }} flag">
                    <span>{{ strtoupper($currentLocale) }}</span>
                </a>
            </div>

            <div class="subscription-shell__body">
                <div class="row g-4 align-items-start">
                    <div class="col-lg-7">
                        <div class="card border-0 shadow-none">
                            <div class="card-body px-0">
                                <h5 class="fw-semibold mb-3">{{ __('messages.payment_method') ?? 'Payment Method' }}</h5>
                                <p class="mb-2 text-muted">{{ __('messages.enter_card_details') ?? 'Enter your card details to subscribe.' }}</p>
                                <form id="payment-form" action="{{ route('subscribe') }}" method="POST" novalidate class="mt-4">
                                    @csrf
                                    <input type="hidden" name="price_id" value="{{ $price_id }}">

                                    <div class="mb-4">
                                        <label class="form-label" for="card-holder-name">{{ __('messages.card_holder_name') ?? 'Card Holder Name' }}</label>
                                        <input type="text" class="form-control" id="card-holder-name" name="card_holder_name"
                                            placeholder="Jane Doe" autocomplete="name"
                                            value="{{ old('card_holder_name', auth()->user()->full_name ?? (auth()->user()->name ?? '')) }}">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label" for="card-number-element">{{ __('messages.card_number') ?? 'Card Number' }}</label>
                                        <div id="card-number-element" class="stripe-field" role="textbox" aria-label="{{ __('messages.card_number') ?? 'Card number' }}"></div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label" for="card-expiry-element">{{ __('messages.expiry_date') ?? 'Expiry Date' }}</label>
                                            <div id="card-expiry-element" class="stripe-field" role="textbox" aria-label="{{ __('messages.expiry_date') ?? 'Expiry date' }}"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="card-cvc-element">{{ __('messages.cvc') ?? 'CVC' }}</label>
                                            <div id="card-cvc-element" class="stripe-field" role="textbox" aria-label="{{ __('messages.cvc') ?? 'Security code' }}"></div>
                                        </div>
                                    </div>

                                    <div id="card-errors" class="text-danger fs-13 mt-3" role="alert"></div>
                                    <p class="fs-13 text-muted d-flex align-items-center gap-2 mt-3">
                                        <i class="ti ti-lock fs-16"></i>
                                        <span>{{ __('messages.transaction_secure') ?? 'Your transaction is secured with encryption.' }}</span>
                                    </p>
                                    <button id="card-button" class="btn btn-primary mt-3"
                                        data-secret="{{ $intent->client_secret }}">
                                        {{ __('messages.subscribe') ?? 'Subscribe' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="card summary-card border-0 shadow-none">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <span class="avatar avatar-xl rounded-circle bg-primary-transparent text-primary fw-bold d-inline-flex align-items-center justify-content-center">
                                        {{ $planInitial }}
                                    </span>
                                    <div>
                                        <div class="fw-semibold plan-title">
                                            {{ $selectedPlanData['label'] ?? __('messages.subscription') }} &ndash; {{ strtolower($selectedIntervalKey) }}
                                        </div>
                                        @if (!empty($selectedPlanData['description']))
                                            <div class="text-muted fs-13">{{ $selectedPlanData['description'] }}</div>
                                        @endif
                                    </div>
                                </div>

                                @if (!empty($features))
                                    <ul class="list-unstyled text-muted fs-13 mb-4">
                                        @foreach ($features as $feature)
                                            <li class="d-flex align-items-start gap-2 mb-2">
                                                <i class="ri-checkbox-circle-fill text-success mt-1"></i>
                                                <span>{{ $feature }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                                <div class="d-flex justify-content-between align-items-baseline mb-3">
                                    <span class="text-muted">{{ __('messages.per_month') ?? '/ month' }}</span>
                                    <span class="fw-semibold plan-price">{{ $perMonthDisplay }}</span>
                                </div>

                                <ul class="list-unstyled cart-order-summary-list">
                                    <li class="d-flex justify-content-between mb-2">
                                        <span>{{ __('messages.sub_total') ?? 'Sub Total' }}</span>
                                        <span class="fw-medium">{{ $totalDueDisplay }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between mb-2">
                                        <span>GST 5%</span>
                                        <span class="fw-medium">{{ $gstDisplay }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between mb-3">
                                        <span>QST 9.975%</span>
                                        <span class="fw-medium">{{ $qstDisplay }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-baseline text-primary">
                                        <span>{{ __('messages.total') ?? 'Total' }}</span>
                                        <span class="fw-semibold h5 mb-0">{{ $grandTotalDisplay }}</span>
                                    </li>
                                </ul>
                                <span class="text-muted fs-12 d-block mt-2">
                                    {{ $billingDescriptor }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
        const elements = stripe.elements();
        const addFocusHandlers = (element, containerId) => {
            const container = document.querySelector(containerId);
            if (!container) {
                return;
            }
            element.on('focus', () => container.classList.add('is-focused'));
            element.on('blur', () => container.classList.remove('is-focused'));
        };

        const stripeElementOptions = { showIcon: true };

        const cardNumberElement = elements.create('cardNumber', stripeElementOptions);
        cardNumberElement.mount('#card-number-element');

        const cardExpiryElement = elements.create('cardExpiry', stripeElementOptions);
        cardExpiryElement.mount('#card-expiry-element');

        const cardCvcElement = elements.create('cardCvc', stripeElementOptions);
        cardCvcElement.mount('#card-cvc-element');

        const elementConfigs = [
            { element: cardNumberElement, selector: '#card-number-element' },
            { element: cardExpiryElement, selector: '#card-expiry-element' },
            { element: cardCvcElement, selector: '#card-cvc-element' },
        ];

        elementConfigs.forEach(({ element, selector }) => {
            addFocusHandlers(element, selector);
        });

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton?.dataset.secret;
        const form = document.getElementById('payment-form');
        const cardErrors = document.getElementById('card-errors');

        if (!form || !cardHolderName || !cardButton || !clientSecret) {
            console.error('Stripe form is missing required elements.');
        } else {
            elementConfigs.forEach(({ element, selector }) => {
                const container = document.querySelector(selector);
                element.on('change', (event) => {
                    if (cardErrors) {
                        cardErrors.textContent = event.error ? event.error.message : '';
                    }
                    if (container) {
                        container.classList.toggle('has-error', Boolean(event.error));
                    }
                });
            });

            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                cardButton.disabled = true;

                const {
                    setupIntent,
                    error
                } = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardNumberElement,
                            billing_details: {
                                name: cardHolderName.value
                            }
                        }
                    }
                );

                if (error) {
                    cardButton.disabled = false;
                    if (cardErrors) {
                        cardErrors.textContent = error.message;
                    }
                } else {
                    const token = document.createElement('input');
                    token.type = 'hidden';
                    token.name = 'payment_method';
                    token.value = setupIntent.payment_method;
                    form.appendChild(token);
                    form.submit();
                }
            });
        }
    </script>
@endsection
