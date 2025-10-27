<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubController;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierWebhookController;

Route::post('stripe/webhook', [CashierWebhookController::class, 'handleWebhook'])
    ->name('cashier.webhook');

/******** Authentication Routes (Unprotected) ********/

// Registration Form (GET)
Route::get('signup', [AuthController::class, 'showRegister'])->name('signup');

// Login Form (GET)
Route::get('login', [AuthController::class, 'showLogin'])->name('login');

// Handle Login Submission (POST)
Route::post('login', [AuthController::class, 'login']);

// Registration Form (GET)
Route::get('register', [AuthController::class, 'showRegister'])->name('register');

// Handle Registration Submission (POST)
Route::post('register', [AuthController::class, 'register'])->name('register.store');

// Subscription view route
Route::get('/subscribe/view', [SubController::class, 'create'])->name('subscribe.view');

// Post-registration pricing page
Route::get('/register/pricing', [SubController::class, 'showPricing'])->name('register.pricing');

// Google Redirect
Route::get('auth/google/redirect', [AuthController::class, 'redirectToGoogle'])->name('google.redirect');

// Google Callback (Handles login/user creation)
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

// Logout (POST request for security)
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Placeholder for registration completion (required for Google OAuth flow)
Route::get('register/complete', function () {
    return view('auth.register-complete');
})->name('register.complete');

/******** Landing Page (Unprotected) ********/
Route::get('welcome', function () {
    return view('landing');
})->name('landing');

Route::get('no-subscription', function () {
    return view('pages.nosub');
})->name('no.subscription');

Route::post('/subscribe', [SubController::class, 'store'])->name('subscribe');

/******** Language Switcher (Unprotected) ********/
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'fr'])) {
        Session::put('locale', $locale);

        // Update user preferences if user is logged in
        if (auth()->check()) {
            \DB::table('user_preferences')
                ->where('user_id', auth()->id())
                ->update(['language' => $locale]);
        }
    }
    return back();
})->name('set.locale');

/******** Theme Switcher (Protected) ********/
Route::get('/theme/{theme}', function (string $theme) {
    if (auth()->check() && in_array($theme, ['light', 'dark'])) {
        \DB::table('user_preferences')
            ->where('user_id', auth()->id())
            ->update(['theme' => $theme]);
    }
    return back();
})->name('set.theme')->middleware('auth');

/******** Protected Application Routes ********/
Route::middleware(['auth', 'subscribed'])->group(function () {

    /******** Dashboard & Home ********/
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::post('/dashboard/refresh-stats', [DashboardController::class, 'refreshStats'])->name('dashboard.refresh-stats');

    /******** Profile Management ********/
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/password', [ProfileController::class, 'editPassword'])->name('profile.edit-password');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::put('profile/preferences', [ProfileController::class, 'updatePreferences'])->name('profile.update-preferences');
    Route::get('profile/login-activity', [ProfileController::class, 'loginActivity'])->name('profile.login-activity');

    /******** Drivers Management ********/
    Route::delete('drivers/bulk-destroy', [DriverController::class, 'bulkDestroy'])->name('drivers.bulkDestroy');
    Route::get('drivers/{driver}/invoices-data', [DriverController::class, 'invoicesData'])->name('drivers.invoices-data');
    Route::get('drivers/check-limit', [DriverController::class, 'checkLimit'])->name('drivers.check-limit');

    // Driver resource routes with subscription limit on create/store
    Route::resource('drivers', DriverController::class)->except(['create', 'store']);
    Route::middleware(['subscription.limit:driver'])->group(function () {
        Route::get('drivers/create', [DriverController::class, 'create'])->name('drivers.create');
        Route::post('drivers', [DriverController::class, 'store'])->name('drivers.store');
    });

    Route::get('drivers/data', [DriverController::class, 'getData'])->name('drivers.data');
    Route::patch('drivers/{driver}/toggle-active', [DriverController::class, 'toggleActive'])->name('drivers.toggle-active');
    Route::get('drivers/{driver}/earnings', [DriverController::class, 'earnings'])->name('drivers.earnings');

    /******** Invoices Management ********/
    // Invoice resource routes with subscription limit on custom invoice creation
    Route::resource('invoices', InvoiceController::class)->except(['create', 'store']);
    Route::middleware(['subscription.limit:custom_invoice'])->group(function () {
        Route::get('invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
        Route::post('invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    });

    Route::post('invoices/{invoice}/mark-paid', [InvoiceController::class, 'markPaid'])->name('invoices.mark-paid');
    Route::post('invoices/{invoice}/mark-unpaid', [InvoiceController::class, 'markUnpaid'])->name('invoices.mark-unpaid');
    Route::post('invoices/mark-paid-bulk', [InvoiceController::class, 'markPaidBulk'])->name('invoices.mark-paid-bulk');

    /******** Expenses Management ********/
    Route::resource('expenses', ExpenseController::class);

    /******** Payments (Legacy Import Feature) ********/
    Route::get('payments', [PaymentController::class, 'importForm'])->name('payments.importForm');
    Route::get('payments/import', [PaymentController::class, 'importForm'])->name('payments.importForm');
    Route::post('payments/preview', [PaymentController::class, 'previewBatch'])->name('payments.previewBatch');
    Route::post('payments/import-batch', [PaymentController::class, 'importBatch'])->name('payments.importBatch');
    Route::post('payments/mark-paid-bulk', [PaymentController::class, 'markPaidBulk'])->name('payments.markPaidBulk');
    Route::post('payments/{payment}/mark-paid', [PaymentController::class, 'markPaid'])->name('payments.markPaid');
    Route::post('payments/check-exists', [PaymentController::class, 'checkExists'])->name('payments.checkExists');
    Route::post('payments/validate-driver-pdf', [PaymentController::class, 'validateDriverPdf'])->name('payments.validateDriverPdf');

    /******** Statistics & Analytics ********/
    Route::get('stats/weekly', [StatsController::class, 'index'])->name('stats.weekly');
    Route::get('stats/drivers', [StatsController::class, 'driverStats'])->name('stats.drivers');
    Route::get('stats/averages', [StatsController::class, 'averageMetrics'])->name('stats.averages');
    Route::get('stats/earnings-by-week', [StatsController::class, 'earningsByWeek'])->name('stats.earnings-by-week');

    /******** Admin-Only Routes ********/
    Route::middleware(['role:admin'])->group(function () {
        // User Management
        Route::resource('users', UserController::class);

        // Subscription Management
        Route::resource('subscriptions', SubscriptionController::class);
        Route::resource('subs', SubController::class);

        // Audit Logs
        Route::resource('audits', AuditLogController::class)->only(['index', 'show']);
        Route::get('audits/export/csv', [AuditLogController::class, 'export'])->name('audits.export');
    });

});
