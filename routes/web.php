<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KategoriController;

// Public Routes
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes (Authenticated Users)
Route::middleware(['auth'])->group(function () {

    // Dashboard

    Route::get('/bakso/{baksoapa} ', function ($baksoapa) {
        return 'bakso apa kamu?     '. $baksoapa;
    })->name('ucan');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Management (Admin Only)
    Route::middleware(['admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    });

    // Products
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::get('products/{product}/stock-history', [ProductController::class, 'stockHistory'])->name('products.stock-history');

    // Categories
    Route::middleware(['admin'])->group(function () {
        Route::resource('kategoris', KategoriController::class);
    });

    // Pelanggans (Customers)
    Route::resource('pelanggans', PelangganController::class);
    Route::post('pelanggans/{pelanggan}/toggle-status', [PelangganController::class, 'toggleStatus'])->name('pelanggans.toggle-status');
    Route::post('pelanggans/{pelanggan}/reset-poin', [PelangganController::class, 'resetPoin'])->name('pelanggans.reset-poin');

    // Transactions (Sales)
    Route::resource('transactions', TransactionController::class);
    Route::get('transactions/{transaction}/receipt', [TransactionController::class, 'receipt'])->name('transactions.receipt');
    Route::post('transactions/{transaction}/refund', [TransactionController::class, 'refund'])->name('transactions.refund');
    Route::get('transactions/{transaction}/details', [TransactionController::class, 'details'])->name('transactions.details');

    // Payment (Midtrans)
    Route::get('payment/{transaction}/snap', [PaymentController::class, 'showSnap'])->name('payment.snap');
    Route::post('payment/create', [PaymentController::class, 'createPayment'])->name('payment.create');
    Route::post('payment/callback', [PaymentController::class, 'handleCallback'])->name('payment.callback');
    Route::post('payment/{transaction}/cancel', [PaymentController::class, 'cancelPayment'])->name('payment.cancel');

    // Reports (Admin Only)
    Route::middleware(['admin'])->group(function () {
        Route::get('reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('reports/sales/daily', [ReportController::class, 'dailySales'])->name('reports.sales.daily');
        Route::get('reports/sales/monthly', [ReportController::class, 'monthlySales'])->name('reports.sales.monthly');
        Route::get('reports/products', [ReportController::class, 'products'])->name('reports.products');
        Route::get('reports/cashiers', [ReportController::class, 'cashiers'])->name('reports.cashiers');
        Route::get('reports/export', [ReportController::class, 'export'])->name('reports.export');
    });

    // Settings (Admin Only)
    Route::middleware(['admin'])->group(function () {
        Route::get('settings', [SettingController::class, 'index'])->name('settings');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
        Route::post('settings/backup', [SettingController::class, 'backup'])->name('settings.backup');
    });

    // Profile & Account
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
