<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController; // Import new controller
use App\Http\Middleware\EnsureUserIsAdmin;

Route::get('/', function () {
    return view('home');
});

Route::get('/comment', function () {
    return view('comment');
});

Route::get('/apropos', function () {
    return view('apropos');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/cgu', function () {
    return view('cgu');
});

Route::get('/charte', function () {
    return view('charte');
});

Route::get('/charte-expediteur', function () {
    return view('charte_expediteur');
});

Route::get('/faqs', function () {
    return view('faq');
});

// Admin Authentication Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Routes (Protected)
Route::middleware(['auth', EnsureUserIsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('users.show'); // New Detail Route
    Route::get('/couriers', [AdminController::class, 'couriers'])->name('users.couriers');
    Route::get('/senders', [AdminController::class, 'senders'])->name('users.senders');

    // KYC
    Route::get('/kyc', [AdminController::class, 'kycList'])->name('kyc.list');
    Route::get('/kyc/{id}', [AdminController::class, 'kycShow'])->name('kyc.show');
    Route::post('/kyc/{id}/approve', [AdminController::class, 'kycApprove'])->name('kyc.approve');
    Route::post('/kyc/{id}/reject', [AdminController::class, 'kycReject'])->name('kyc.reject');
    
    // Operations
    Route::get('/parcels', [AdminController::class, 'parcels'])->name('parcels');
    Route::get('/sos', [AdminController::class, 'sos'])->name('sos');
});
