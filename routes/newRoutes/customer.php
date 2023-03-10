<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['customer-auth', 'verified']], function () {

});
