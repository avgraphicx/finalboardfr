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

// Placeholder for registration completion (required for Google OAuth flow)
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
Route::middleware(['auth'])->group(function () {

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
    Route::resource('drivers', DriverController::class);
    Route::get('drivers/data', [DriverController::class, 'getData'])->name('drivers.data');
    Route::delete('drivers/bulk-destroy', [DriverController::class, 'bulkDestroy'])->name('drivers.bulkDestroy');
    Route::patch('drivers/{driver}/toggle-active', [DriverController::class, 'toggleActive'])->name('drivers.toggle-active');
    Route::get('drivers/{driver}/earnings', [DriverController::class, 'earnings'])->name('drivers.earnings');

    /******** Invoices Management ********/
    Route::resource('invoices', InvoiceController::class);
    Route::post('invoices/{invoice}/mark-paid', [InvoiceController::class, 'markPaid'])->name('invoices.mark-paid');
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

        // Audit Logs
        Route::resource('audits', AuditLogController::class)->only(['index', 'show']);
        Route::get('audits/export/csv', [AuditLogController::class, 'export'])->name('audits.export');
    });

});
