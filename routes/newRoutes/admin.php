<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as DashboardController;
use App\Http\Controllers\Admin\VehicleController as VehicleController;
use App\Http\Controllers\Admin\PromoCodeController as PromoCodeController;
use App\Http\Controllers\Admin\HomePageController as HomePageController;
use App\Http\Controllers\Admin\ReservationController as ReservationController;

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

    // Reservation
    Route::get('/active-reservations', [ReservationController::class, 'activeReservations'])->name('reservation.active');
    Route::get('/cancelled-reservations', [ReservationController::class, 'cancelledReservations'])->name('reservation.cancel');
    Route::get('/completed-reservations', [ReservationController::class, 'completedReservations'])->name('reservation.complete');
    Route::get('/reservations/show/{id}', [ReservationController::class, 'show'])->name('reservation.showOne');
    Route::get('/reservation/{id}/edit', [ReservationController::class, 'edit'])->name('reservation.edit');
    Route::put('/reservation/{id}', [ReservationController::class, 'update'])->name('reservation.update');
    Route::get('/reservation/mark-as-refunded/{id}', [ReservationController::class, 'markCancelledAsRefunded'])->name('reservation.refunded');
});
