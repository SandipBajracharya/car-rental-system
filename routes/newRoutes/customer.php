<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\HomeController as HomeController;
use App\Http\Controllers\Customer\AdditionalUserInfoController as AdditionalUserInfoController;

Route::group(['middleware' => ['customer-auth', 'verified'], 'prefix' => 'c'], function () {
    Route::get('/profile-setting', [AdditionalUserInfoController::class, 'showProfilePage'])->name('profileSetting');
    Route::post('/update-user-profile', [AdditionalUserInfoController::class, 'updateUserProfile'])->name('userProfile.update');
    Route::post('/password-change', [AdditionalUserInfoController::class, 'changePassword'])->name('password.change');
});
