@extends('layouts.master')

@section('content')
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.subscriptions') ?? 'Subscriptions' }}</h1>
            <a href="{{ route('subscriptions.create') }}" class="btn btn-sm btn-primary">
                <i class="ri-add-line me-2"></i>{{ __('messages.add_subscription') ?? 'Add Subscription' }}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card custom-card">
                <div class="card-body">
                    @if ($subscriptions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.broker') ?? 'Broker' }}</th>
                                        <th>{{ __('messages.type') ?? 'Type' }}</th>
                                        <th>{{ __('messages.status') ?? 'Status' }}</th>
                                        <th>{{ __('messages.ends_at') ?? 'Ends At' }}</th>
                                        <th>{{ __('messages.actions') ?? 'Actions' }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscriptions as $sub)
                                        <tr>
                                            <td>{{ $sub->broker->full_name }}</td>
                                            <td>{{ $sub->subscriptionType->name }}</td>
                                            <td>{{ $sub->stripe_status }}</td>
                                            <td>{{ $sub->ends_at?->format('Y-m-d') }}</td>
                                            <td>
                                                <a href="{{ route('subscriptions.edit', $sub) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            {{ __('messages.no_subscriptions_found') ?? 'No subscriptions found.' }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
