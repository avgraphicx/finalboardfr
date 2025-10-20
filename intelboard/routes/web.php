<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\PaymentController;

/******** Authentication Routes (Unprotected) ********/

// Login Form (GET)
Route::get('login', [AuthController::class, 'showLogin'])->name('login');

// Handle Login Submission (POST)
Route::post('login', [AuthController::class, 'login']);

// Google Redirect
Route::get('auth/google/redirect', [AuthController::class, 'redirectToGoogle'])->name('google.redirect');

// Google Callback (Handles login/user creation)
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

// Logout (POST request for security)
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Placeholder for registration continuation (required for Google logic)
Route::get('register/complete', function () {
    return view('auth.register-complete');
})->name('register.complete');



/******** Language Switcher (Unprotected) ********/
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'fr'])) {
        // Supported languages
        Session::put('locale', $locale);
    }
    return back();
})->name('set.locale');

/******** Protected Application Routes ********/
// All users (admin, broker, supervisor) must be authenticated and have a valid role
Route::middleware(['auth', 'role:admin,broker,supervisor'])->group(function () {
    /******** Default Route ********/
    Route::get('/', function () {
        return view('pages.empty'); // points to resources/views/pages/empty.blade.php
    })->name('index');

    // Fallback if directly accessing /
    // Route::get('/', [DashboardsController::class, 'index']);

    /******** Drivers ********/
    Route::get('drivers/data', [DriverController::class, 'getData'])->name('drivers.data');

    // 2. Resource Routes
    Route::resource('drivers', DriverController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

    // 3. Bulk Delete Route
    Route::delete('drivers/bulk-destroy', [DriverController::class, 'bulkDestroy'])->name('drivers.bulkDestroy');

    /******** Payments ********/
    // Custom routes must be defined BEFORE the resource route
    Route::post('payments/mark-paid-bulk', [PaymentController::class, 'markPaidBulk'])->name('payments.markPaidBulk');
    Route::post('payments/{payment}/mark-paid', [PaymentController::class, 'markPaid'])->name('payments.markPaid');
    // Check if payment exists for given driver and week
    Route::post('payments/check-exists', [PaymentController::class, 'checkExists'])->name('payments.checkExists');
    Route::resource('payments', PaymentController::class);


});
