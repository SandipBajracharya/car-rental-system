<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\HomeController as HomeController;
use App\Http\Controllers\Customer\AdditionalUserInfoController as AdditionalUserInfoController;

Route::group(['middleware' => ['customer-auth', 'verified'], 'prefix' => 'c'], function () {

});
