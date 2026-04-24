<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\TripInfo;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DriverController;
use Illuminate\Http\Request;
use App\Models\Item;

use App\Http\Controllers\ItemController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\BookingController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/booking', [\App\Http\Controllers\api\BookingTrip::class, 'Booking']);
Route::get('/trip/{id}', [TripInfo::class, 'getTripById']);

Route::get('/search', [ItemController::class, 'search']);

Route::get('/trips/{id}', [TripController::class, 'show']);

    Route::post('/booking/{id}/accept', [BookingController::class, 'accept']);
    Route::post('/booking/{id}/reject', [BookingController::class, 'reject']);

//Route::get('/search', [SearchController::class, 'search']);
Route::delete('/trips/{id}', [TripController::class, 'destroy']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/verify-code', [AuthController::class, 'verifyCode']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::get('/trips/{id}', [TripController::class, 'show']);

Route::post('/booking/{id}/accept', [BookingController::class, 'accept']);
Route::post('/booking/{id}/reject', [BookingController::class, 'reject']);



Route::middleware('auth:api')->post('/driver', [DriverController::class, 'store']);
Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    //Route::get('/trips/{id}', [TripController::class, 'show']);
    //Route::post('/booking/{id}/accept', [BookingController::class, 'accept']);
    //Route::post('/booking/{id}/reject', [BookingController::class, 'reject']);

});

Route::middleware('auth:api')->post('/driver', [DriverController::class, 'store']);
