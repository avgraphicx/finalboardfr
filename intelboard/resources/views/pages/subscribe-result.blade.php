@extends('layouts.custom-master')

@section('styles')
    <style>
        .subscription-result {
            max-width: 640px;
            margin: 4rem auto;
            text-align: center;
        }

        .subscription-result .icon-wrapper {
            width: 82px;
            height: 82px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.25rem;
            margin-bottom: 1.25rem;
        }

        .subscription-result .icon-success {
            background: rgba(34, 197, 94, 0.12);
            color: #16a34a;
        }

        .subscription-result .icon-error {
            background: rgba(239, 68, 68, 0.12);
            color: #dc2626;
        }
    </style>
@endsection

@section('content')
    <div class="subscription-result card border-0 shadow-sm p-5">
        <div class="icon-wrapper {{ $status === 'success' ? 'icon-success' : 'icon-error' }}">
            @if ($status === 'success')
                <i class="ti ti-circle-check"></i>
            @else
                <i class="ti ti-circle-x"></i>
            @endif
        </div>
        <h2 class="fw-semibold mb-3">
            {{ $status === 'success' ? __('messages.subscription_success_title') ?? 'Subscription Activated' : __('messages.subscription_failed_title') ?? 'Subscription Failed' }}
        </h2>
        <p class="text-muted mb-4">
            {{ $message ?? ($status === 'success'
                ? __('messages.subscription_success') ?? 'Your subscription is now active.'
                : __('messages.subscription_failed') ?? 'There was an issue processing your subscription.') }}
        </p>
        <p class="text-muted fs-13">
            {{ __('messages.redirect_notice') ?? 'You will be redirected shortly.' }}
        </p>
        <a href="{{ $redirect_url ?? route('index') }}" class="btn btn-primary mt-3">
            {{ __('messages.go_now') ?? 'Go now' }}
        </a>
    </div>
@endsection

@section('scripts')
    <script>
        setTimeout(() => {
            window.location.href = @json($redirect_url ?? route('index'));
        }, {{ ($redirect_delay ?? 5) * 1000 }});
    </script>
@endsection
