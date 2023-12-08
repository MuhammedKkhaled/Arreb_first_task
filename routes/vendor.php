<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use  App\Http\Controllers\vendor\VendorHomeController;
use  App\Http\Controllers\vendor\auth\VendorLoginController;
use  App\Http\Controllers\vendor\auth\VendorRegisterController;
/*
|--------------------------------------------------------------------------
| Vendor Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

####################### Begin Routes For Vendor ##################################

Route::prefix('vendor/')->name('vendor.')->group(function () {

    Route::get('home', [VendorHomeController::class, 'index'])->name("home")->middleware("auth:vendor");

    Route::get('login', [VendorLoginController::class, 'login'])->name('login');

    Route::post("login", [VendorLoginController::class, 'is_vendor'])->name('check.login');

    Route::post('logout', [VendorLoginController::class, 'logout'])->name('logout');

    Route::get('register', [VendorRegisterController::class, 'register'])->name('register');

    Route::post("register", [VendorRegisterController::class, 'store'])->name('store');
});
    
####################### End Routes For Vendor ####################################