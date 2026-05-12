<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\NotificationController;
use App\Http\Controllers\api\TripInfo;

use App\Http\Controllers\RatingController;
use App\Http\Controllers\api\Trips;
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

Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/verify-code', [AuthController::class, 'verifyCode']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);



    Route::post('/booking/{id}/accept', [BookingController::class, 'accept']);
    Route::post('/booking/{id}/reject', [BookingController::class, 'reject']);


Route::middleware('auth:api')->group(function () {
    Route::get('/search', [ItemController::class, 'search']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/booking', [Trips::class, 'Booking']);
    Route::get('/myBooking', [Trips::class, 'myBookings']);
    Route::put('/booking/{id}/status', [NotificationController::class, 'changeStatusBooking']);
    Route::get('/trip/{id}', [TripInfo::class, 'getTripById']);
    Route::get('/notification', [NotificationController::class, 'getNotification']);
    Route::put('/notification/{id}', [NotificationController::class, 'notificationRead']);
    Route::put('/user/update', [AuthController::class, 'update']);
    Route::put('/user/update-password', [AuthController::class, 'updatePassword']);
    Route::post('/user/update-image', [AuthController::class, 'updateImage']);
    Route::post('/driver', [DriverController::class, 'store']);
    Route::get('/getTripUser', [Trips::class, 'GetTrip']);
  //  Route::get('/getTripUser', [\App\Http\Controllers\api\Trips::class, 'GetTrip']);
    Route::post('/rating', [RatingController::class, 'store']);
    Route::post('/notificationFavorite', [NotificationController::class, 'notificationForFavorite']);
    Route::get('/finished-trip', [RatingController::class, 'finishedTrip']);
    Route::post('/favorite', [RatingController::class, 'addFavorite']);
    Route::get('/favorite-drivers', [AuthController::class, 'favoriteDrivers']);
    Route::delete('/favorite-drivers/{driverId}', [AuthController::class, 'removeFavoriteDriver']);
    Route::post('/driver', [DriverController::class, 'store']);

});






Route::middleware(['auth:api', 'isDriver'])->group(function () {
    Route::post('/schedule-trip', [Trips::class, 'Schedule']);
    Route::get('/driver/stats', [DriverController::class, 'stats']);
    Route::get('/driver/current-trip', [DriverController::class, 'currentTrip']);
    Route::post('/driver/trip/{id}/start', [DriverController::class, 'startTrip']);
    Route::post('/driver/trip/{id}/end', [DriverController::class, 'endTrip']);
    Route::get('/driver/upcoming-trips', [DriverController::class, 'upcomingTrips']);
    Route::get('/trips/{id}', [TripController::class, 'show']);
    Route::put('/trips/{id}', [TripController::class, 'update']);
    Route::delete('/trips/{id}', [TripController::class, 'destroy']);


});

