<?php

use App\Application\Http\Controllers\Api\V1\AuthController;
use App\Application\Http\Controllers\Api\V1\CustomerController;
use App\Application\Http\Controllers\Api\V1\ProposalController;
use App\Application\Http\Controllers\Api\V1\SaleController;
use App\Application\Http\Controllers\Api\V1\VehicleController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function (): void {
    Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');

    Route::middleware(['auth:api'])->group(function (): void {
        Route::post('auth/refresh', [AuthController::class, 'refresh'])->name('auth.refresh');
        Route::post('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
        Route::get('auth/me', [AuthController::class, 'profile'])->name('auth.profile');

        Route::apiResource('customers', CustomerController::class);

        Route::apiResource('vehicles', VehicleController::class);
        Route::patch('vehicles/{vehicle}/status', [VehicleController::class, 'updateStatus'])->name('vehicles.status');

        Route::apiResource('proposals', ProposalController::class);
        Route::post('proposals/{proposal}/submit', [ProposalController::class, 'submit'])->name('proposals.submit');
        Route::post('proposals/{proposal}/checkout', [ProposalController::class, 'checkout'])->name('proposals.checkout');

        Route::get('sales', [SaleController::class, 'index'])->name('sales.index');
        Route::get('sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
        Route::post('sales/{sale}/finalize', [SaleController::class, 'finalize'])->name('sales.finalize');
    });
});

