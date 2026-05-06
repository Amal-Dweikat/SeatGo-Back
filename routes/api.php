<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\TripInfo;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DriverController;
use Illuminate\Http\Request;
use App\Models\Item;

use App\Http\Controllers\ItemController;
use App\Http\Controllers\SearchController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/search', [ItemController::class, 'search']);
Route::get('/test', function () {
    return "hello";
});



Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/booking', [\App\Http\Controllers\api\BookingTrip::class, 'Booking']);
    Route::get('/trip/{id}', [TripInfo::class, 'getTripById']);
    Route::put('/user/update', [AuthController::class, 'update']);
    Route::put('/user/update-password', [AuthController::class, 'updatePassword']);
    Route::post('/user/update-image', [AuthController::class, 'updateImage']);
    Route::post('/driver', [DriverController::class, 'store']);
});


Route::middleware(['auth:api', 'isDriver'])->group(function () {
    Route::get('/driver/stats', [DriverController::class, 'stats']);
    Route::get('/driver/current-trip', [DriverController::class, 'currentTrip']);
    Route::post('/driver/trip/{id}/start', [DriverController::class, 'startTrip']);
    Route::post('/driver/trip/{id}/end', [DriverController::class, 'endTrip']);

});

