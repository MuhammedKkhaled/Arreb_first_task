<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApiAdminAuthController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\FuncCall;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Create a route resource ,
Route::resource("products", ProductController::class);


///  For public routes

Route::post("register", [AuthController::class, 'register']);
Route::post("login", [AuthController::class, 'login']);


/// Protected Routes 
Route::group(["middleware" => ['auth:sanctum']], function () {
    Route::post("products", [ProductController::class, 'store']);
    Route::put("products/{id}", [ProductController::class, 'update']);
    Route::delete("products/{id}", [ProductController::class, 'destroy']);
    Route::post("logout", [AuthController::class, 'logout']);
});

################### Admin Routes #####################
Route::prefix("admin/")->name('admin.')->group(function () {
    Route::post("register", [ApiAdminAuthController::class, "register"])->name('register');
    Route::post("login", [ApiAdminAuthController::class, "login"])->name('login');
});
