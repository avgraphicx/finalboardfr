@extends('layouts.custom-master')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Subscribe</div>
                    <div class="card-body">
                        <form id="payment-form" action="{{ route('subscribe') }}" method="POST">
                            @csrf
                            <input type="hidden" name="price_id" value="{{ $price_id }}">
                            <div class="form-group">
                                <label for="card-holder-name">Card Holder Name</label>
                                <input id="card-holder-name" type="text" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="card-element">Credit or debit card</label>
                                <div id="card-element" class="form-control"></div>
                                <!-- Used to display form errors. -->
                                <div id="card-errors" role="alert" class="text-danger"></div>
                            </div>

                            <button id="card-button" class="btn btn-primary mt-3"
                                data-secret="{{ $intent->client_secret }}">
                                Subscribe
                            </button>
                        </form>
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
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;
        const form = document.getElementById('payment-form');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            cardButton.disabled = true;

            const {
                setupIntent,
                error
            } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: cardHolderName.value
                        }
                    }
                }
            );

            if (error) {
                cardButton.disabled = false;
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
            } else {
                let token = document.createElement('input');
                token.setAttribute('type', 'hidden');
                token.setAttribute('name', 'payment_method');
                token.setAttribute('value', setupIntent.payment_method);
                form.appendChild(token);
                form.submit();
            }
        });
    </script>
@endsection
