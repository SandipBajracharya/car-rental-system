<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController as MainController;
use App\Http\Controllers\GoogleSocialiteController as GoogleSocialiteController;
use App\Http\Controllers\FacebookSocialiteController as FacebookSocialiteController;
use App\Http\Controllers\Customer\AdditionalUserInfoController as AdditionalUserInfoController;
use App\Http\Controllers\Customer\ReservationController as ReservationController;
use App\Http\Controllers\GuestController as GuestController;
Use App\Http\Controllers\Customer\CustomerController as CustomerController;
use App\Http\Controllers\PaypalController as PaypalController;
use App\Http\Controllers\StripeController as StripeController;

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
Route::get('/faq', [MainController::class, 'viewFaqs'])->name('faq');
Route::get('/contact-us', [MainController::class, 'contactUsPage'])->name('contactUs');
Route::post('/feedback', [MainController::class, 'addFeedback'])->name('feedback.add');
Route::get('/about-us', [MainController::class, 'aboutUsPage'])->name('aboutus');

// checkout as guest
Route::post('/store-guest-info', [GuestController::class, 'storeGuestInfo'])->name('guest.store');
Route::post('/process-guest-reservation', [GuestController::class, 'processCarReservationAsGuest'])->name('process_reservation.store');

// socialite urls
// Google
Route::get('auth/google', [GoogleSocialiteController::class, 'redirectToGoogle']);
Route::get('callback/google', [GoogleSocialiteController::class, 'handleCallback']);

//Facebook
Route::get('auth/facebook', [FacebookSocialiteController::class, 'redirectToFacebook']);
Route::get('callback/facebook', [FacebookSocialiteController::class, 'handleCallback']);

Route::group(['middleware' => ['auth', 'verified']], function() {
    Route::post('/store-additional-user-info', [AdditionalUserInfoController::class, 'storeAdditionalInfo'])->name('user.store-addn-info');

    Route::get('/profile-setting', [AdditionalUserInfoController::class, 'showProfilePage'])->name('profileSetting');
    Route::post('/update-user-profile', [AdditionalUserInfoController::class, 'updateUserProfile'])->name('userProfile.update');
    Route::post('/password-change', [AdditionalUserInfoController::class, 'changePassword'])->name('password.change');
    
    // checkout
    Route::get('/checkout', [ReservationController::class, 'checkout'])->name('checkout');

    // booking history
    Route::get('/booking-history', [CustomerController::class, 'showCustomerHistory']);
    Route::put('/cancel-reservation', [CustomerController::class, 'cancelReservation'])->name('cancel.reservation');
});

// Reservation
Route::get('/find-car', [ReservationController::class, 'findCar'])->name('find.car');
Route::get('/checkout-as-guest', [ReservationController::class, 'checkoutAsGuest'])->name('checkout.guest');
Route::get('/payment-option', [ReservationController::class, 'paymentOption'])->name('payment.option');
Route::post('/process-reservation', [ReservationController::class, 'processCarReservation'])->name('reserve.car');

// Check availability
Route::get('/check-vehicle-availability/{vehicle_id}', [ReservationController::class, 'checkVehicleAvailability'])->name('check.availability');

// Reservation Complete
Route::get('/reservation-complete', [MainController::class, 'reservationComplete']);

// Paypal
Route::get('paywithpaypal', [PaypalController::class, 'payWithPaypal'])->name('paywithpaypal');
Route::post('paypal', [PaypalController::class, 'postPaymentWithpaypal'])->name('paypal');
Route::get('paypal', [PaypalController::class, 'getPaymentStatus'])->name('status');

// Stripe
Route::get('stripe', [StripeController::class, 'stripe']);
Route::post('stripe', [StripeController::class, 'stripePost'])->name('stripe.post');
