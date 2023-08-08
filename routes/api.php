<?php

use App\Http\Controllers\SaveCardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\RegisterController;


Route::post('login', [LoginController::class, 'login']);
Route::post('login/verify', [LoginController::class, 'verify']);
Route::post('signup', [RegisterController::class, 'register']);
Route::post('webhook', [\App\Http\Controllers\Paystack\PaystackWebhook::class, 'handle']);

Route::prefix('auth')->middleware('auth:sanctum')->group(function () {


    Route::get('user', fn(Request $request) =>  $request->user());

    // Driver
    Route::get('driver', [DriverController::class, 'show']);
    Route::post('driver', [DriverController::class, 'update']);

     // Trip
     Route::post('trip', [TripController::class, 'store']);
     Route::get('trip/{trip}', [TripController::class, 'show']);
     Route::post('trip/{trip}/accept', [TripController::class, 'accept']);
     Route::post('trip/{trip}/end', [TripController::class, 'end']);
     Route::post('trip/{trip}/start', [TripController::class, 'start']);
     Route::post('trip/{trip}/location', [TripController::class, 'location']);
     Route::post('trip/{trip}/pay', [TripController::class,'pay']);

    //payment
    Route::post('initialize', [SaveCardController::class, 'initialize']);
});
