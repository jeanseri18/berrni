<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ParcelController;
use App\Http\Controllers\Api\KycController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\MessageController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);

    // Parcels
    Route::get('/parcels', [ParcelController::class, 'index']);
    Route::post('/parcels', [ParcelController::class, 'store']);
    Route::get('/parcels/{id}', [ParcelController::class, 'show']);
    Route::put('/parcels/{id}', [ParcelController::class, 'update']);
    Route::post('/parcels/{id}/accept', [ParcelController::class, 'accept']);

    // Messages
    Route::get('/parcels/{id}/messages', [MessageController::class, 'index']);
    Route::post('/parcels/{id}/messages', [MessageController::class, 'store']);

    // KYC
    Route::post('/kyc', [KycController::class, 'submit']);
    Route::get('/kyc/status', [KycController::class, 'status']);

    // Wallet
    Route::get('/wallet', [WalletController::class, 'show']);
});
