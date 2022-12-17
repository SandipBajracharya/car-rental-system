<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController as MainController;
use App\Http\Controllers\GoogleSocialiteController as GoogleSocialiteController;
use App\Http\Controllers\FacebookSocialiteController as FacebookSocialiteController;
use App\Http\Controllers\Customer\AdditionalUserInfoController as AdditionalUserInfoController;
use App\Http\Controllers\Customer\ReservationController as ReservationController;
use App\Http\Controllers\GuestController as GuestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Auth
Auth::routes(['verify' => true]);

Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/car-listing', [MainController::class, 'carListing'])->name('car.listing');
Route::get('/car-detail/{slug}', [MainController::class, 'viewCarDetail'])->name('car.detail');
Route::get('/modal-car-detail', [MainController::class, 'ajaxCarDetail'])->name('ajax.car-detail');

// checkout as guest
Route::post('/store-guest-info', [GuestController::class, 'processCarReservationAsGuest'])->name('process_reservation.store');

// socialite urls
// Google
Route::get('auth/google', [GoogleSocialiteController::class, 'redirectToGoogle']);
Route::get('callback/google', [GoogleSocialiteController::class, 'handleCallback']);

//Facebook
Route::get('auth/facebook', [FacebookSocialiteController::class, 'redirectToFacebook']);
Route::get('callback/facebook', [FacebookSocialiteController::class, 'handleCallback']);

Route::group(['middleware' => 'auth'], function() {
    Route::post('/store-additional-user-info', [AdditionalUserInfoController::class, 'storeAdditionalInfo'])->name('user.store-addn-info');
    Route::post('/store-additional-user-info', [AdditionalUserInfoController::class, 'storeAdditionalInfo'])->name('user.store-addn-info');
});

// Reservation
Route::get('/find-car', [ReservationController::class, 'findCar'])->name('find.car');
Route::get('/checkout', [ReservationController::class, 'checkout'])->name('checkout');
Route::get('/checkout-as-guest', [ReservationController::class, 'checkoutAsGuest'])->name('checkout.guest');
Route::post('/process-reservation', [ReservationController::class, 'processCarReservation'])->name('reserve.car');
