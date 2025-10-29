@extends('layouts.master')

@section('styles')
@endsection

@section('content')
    <!-- Start::page-header -->
    <div class="page-header-breadcrumb mb-3">
        <div class="d-flex align-center justify-content-between flex-wrap">
            <h1 class="page-title fw-medium fs-18 mb-0">{{ __('messages.empty') }}</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">{{ __('messages.pages') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.empty') }}</li>
            </ol>
        </div>
    </div>
    <!-- End::page-header -->

    <!-- Start::row-1 -->
    <div class="container">
        <div class="row">
            <div class="col-xl-8">
                <div class="card custom-card border-0 shadow-none">
                    <div class="card-body">
                        <div class="mb-4">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    {{ __('messages.logout') }}
                                </button>
                            </form>
                        </div>
                        <div>
                            <h5 class="fw-semibold mb-3">Payment Method</h5>
                            <p class="mb-2 mt-4 fw-medium">Card Details:</p>
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="cardHolderName"
                                        placeholder="Card Holder Name">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="cardNumber" placeholder="Card Number">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="expDate" placeholder="Expiry Date">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="cvv" placeholder="CVV">
                                </div>
                            </div>
                            <p class="mb-3 mt-2 fs-13 text-muted">
                                <span><i class="ti ti-lock fs-16"></i></span>
                                <span>Your transaction is secured with encryption.</span>
                            </p>
                            <a href="javascript:void(0);" class="btn btn-primary">
                                Proceed to pay <i class="ti ti-arrow-right fs-18 ms-2 align-middle"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xl-4">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="d-flex align-items-center gap-3 flex-wrap flex-sm-nowrap">
                                    <div class="lh-1">
                                        <span class="avatar avatar-xxl">
                                            <img src="/assets/images/ecommerce/jpg/1.jpg" alt="">
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="fw-semibold d-block mb-2">Adidas UltraBoost 2023</span>
                                        <span class="text-muted d-block fs-13 mb-1">Color : Green</span>
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <span class="text-muted d-block fs-13">Qty : 2 x $159.99 </span>
                                            <div class="fw-semibold">$319.98</div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center gap-3 flex-wrap flex-sm-nowrap">
                                    <div class="lh-1">
                                        <span class="avatar avatar-xxl">
                                            <img src="/assets/images/ecommerce/jpg/2.jpg" alt="">
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="fw-semibold d-block mb-2">Reebok Classic Leather</span>
                                        <span class="text-muted d-block fs-13 mb-1">Color : Blue</span>
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <span class="text-muted d-block fs-13">Qty : 1 x $89.99 </span>
                                            <div class="fw-semibold">$89.99</div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center gap-3 flex-wrap flex-sm-nowrap">
                                    <div class="lh-1">
                                        <span class="avatar avatar-xxl">
                                            <img src="/assets/images/ecommerce/jpg/4.jpg" alt="">
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="fw-semibold d-block mb-2">Nike Air Max 2025 Sneakers</span>
                                        <span class="text-muted d-block fs-13 mb-1">Color : Teal Blue</span>
                                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                                            <span class="text-muted d-block fs-13">Qty : 1 x $129.99 </span>
                                            <div class="fw-semibold">$129.99</div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <ul class="list-unstyled cart-order-summary-list mt-3">
                            <li>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>Sub Total</div>
                                    <div class="fw-medium">$929.79</div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>Discount (10%)</div>
                                    <div class="fw-medium">- $92.97</div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>Tax</div>
                                    <div class="fw-medium">$0.00</div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center justify-content-between text-primary">
                                    <div>Total</div>
                                    <div class="fw-semibold h5 mb-0 text-primary">$836.82</div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End::row-1 -->
@endsection

@section('scripts')
@endsection
