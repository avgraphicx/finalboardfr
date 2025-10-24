<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StatsController;
use App\Models\Driver;
use App\Models\Payment;
use App\Http\Controllers\ExpenseController;

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
        Session::put('locale', $locale);
    }
    return back();
})->name('set.locale');

/******** Protected Application Routes ********/
Route::middleware(['auth', 'role:admin,broker,supervisor'])->group(function () {
    /******** Default Route ********/
    // Stats page (dashboard)
    // Route::get('/', function () {
    //     return view('pages.empty');
    // })->name('index');
        Route::get('/', [StatsController::class, 'index'])->name('index');

    // Profile page
    Route::get('profile', function () {
        $user = \Illuminate\Support\Facades\Auth::user()
            ->load(['broker.subscriptionType', 'broker.subscription']);
        return view('pages.profile', compact('user'));
    })->name('profile');

    /******** Drivers ********/
    Route::get('drivers/data', [DriverController::class, 'getData'])->name('drivers.data');
    Route::resource('drivers', DriverController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
    Route::delete('drivers/bulk-destroy', [DriverController::class, 'bulkDestroy'])->name('drivers.bulkDestroy');

    /******** Payments ********/
    // Make payments.index show the Import form
    Route::get('payments', [PaymentController::class, 'importForm'])->name('payments.index');

    // Preview/Import flow (no JS business logic in Blade)
    Route::get('payments/import', [PaymentController::class, 'importForm'])->name('payments.importForm');
    Route::post('payments/preview', [PaymentController::class, 'previewBatch'])->name('payments.previewBatch');
    Route::post('payments/import-batch', [PaymentController::class, 'importBatch'])->name('payments.importBatch');

    // Custom routes
    Route::post('payments/mark-paid-bulk', [PaymentController::class, 'markPaidBulk'])->name('payments.markPaidBulk');
    Route::post('payments/{payment}/mark-paid', [PaymentController::class, 'markPaid'])->name('payments.markPaid');
    Route::post('payments/check-exists', [PaymentController::class, 'checkExists'])->name('payments.checkExists');

    // Payments resource (exclude index so our custom payments.index above is used)
    Route::resource('payments', PaymentController::class)->except(['index']);
        // Expenses resource
        Route::resource('expenses', ExpenseController::class);

});
