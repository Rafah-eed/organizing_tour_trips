<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('trip', 'TripController');
// Route::apiResource('customer', 'customerController');
// Route::apiResource('bookHotel', 'bookHotelController');
// Route::apiResource('bookRestaurant', 'bookRestaurantController');
// Route::apiResource('guide', 'guideController');
// Route::apiResource('guideTrip', 'guideTripController');
// Route::apiResource('Hotel', 'HotelController');
// Route::apiResource('Rating', 'RatingController');
// Route::apiResource('restaurant', 'restaurantController');
// Route::apiResource('station', 'stationController');
// Route::apiResource('stationTrip', 'stationTripController');

// Route::apiResource('user', 'userController');
// Route::apiResource('userTrip', 'userTripController');
// Route::apiResource('workGuide', 'workGuideController');

