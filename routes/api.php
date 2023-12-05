<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CarpackController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SpaceController;
use Illuminate\Support\Facades\Route;


    Route::middleware('guest')->group(function () {
    Route::post('/register', [AuthenticationController::class, 'register']);
    Route::post('/login', [AuthenticationController::class, 'login']);
    Route::post('/operator', [AuthenticationController::class, 'operatorLogin']);
    Route::post('/admin', [AuthenticationController::class, 'adminLogin']);
    Route::get('/get-carpack', [CarpackController::class, 'getCarpack']);
    Route::get('/get-total-counts', [DashboardController::class,  'getTotalCounts']);
});

Route::middleware('auth:sanctum')->group( function () {
    Route::get('/get-space', [SpaceController::class, 'getAllSpacesWithCarparks']);
Route::post('/logout', [AuthenticationController::class, 'logout']);
Route::post('/reservation', [ReservationController::class, 'createReservation']);
Route::post('/status', [SpaceController::class, 'createSpaceStatus']);
Route::post('/carpack', [CarpackController::class, 'createCarpack']);
Route::post('/space', [SpaceController::class, 'createSpace']);
Route::Post('/spaces/{spaceId}/create-booking-payment', [BookingController::class, 'createBookingPaymentForSpace']);
Route::Post('/spaces/{spaceId}/create-booking-reservation', [ReservationController::class, 'createReservationForSpace']);

});
