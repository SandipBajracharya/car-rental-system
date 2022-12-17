<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as DashboardController;
use App\Http\Controllers\Admin\VehicleController as VehicleController;
use App\Http\Controllers\Admin\PromoCodeController as PromoCodeController;
use App\Http\Controllers\Admin\HomePageController as HomePageController;

Route::group(['middleware' => ['admin-auth', 'verified'], 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');
    // vehicle
    Route::resource('/vehicle', VehicleController::class);
    Route::get('/update-vehicle-availability/{id}', [VehicleController::class, 'updateAvailability'])->name('vehicle.availability');

    // promo code
    Route::resource('/promo-code', PromoCodeController::class);
    Route::get('/update-promo-code-status/{id}', [PromoCodeController::class, 'updateStatus'])->name('promoCode.status');

    // landing CMS
    Route::resource('/home-slider', HomePageController::class);
    Route::put('/home-page/top-vehicles', [HomePageController::class, 'updateHomeTopVehicles'])->name('homepage.topVehicle');
});
