<?php

use App\Http\Controllers\StationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TripController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::apiResource('trip', TripController::class);
Route::apiResource('station', StationController::class);
Route::apiResource('user', UserController::class);
// Route::apiResource('bookStation', 'bookHotelController');
// Route::apiResource('bookRestaurant', 'bookRestaurantController');
// Route::apiResource('guide', 'guideController');
// Route::apiResource('guideTrip', 'guideTripController');
// Route::apiResource('Hotel', 'HotelController');
// Route::apiResource('Rating', 'RatingController');
// Route::apiResource('restaurant', 'restaurantController');
// Route::apiResource('stationTrip', 'stationTripController');

// Route::apiResource('user', 'userController');
// Route::apiResource('userTrip', 'userTripController');
// Route::apiResource('workGuide', 'workGuideController');

Route::controller(UserController::class)->group(function () {
    Route::get('getAllGuides', 'getAllGuides');
    Route::get('getAllCustomers', 'getAllCustomers');
});



Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});





