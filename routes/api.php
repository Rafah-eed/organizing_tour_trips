<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\GuidesDetailsController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\StationTripController;
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
Route::apiResource('stationTrip', StationTripController::class);
Route::apiResource('comment', CommentController::class);
Route::post('/guidesDetails', [GuidesDetailsController::class, 'create']);
Route::post('/trip/{trip_id}', [TripController::class, 'tripById']);



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

Route::get('/trip/{trip}/stations', [TripController::class, 'allStationsForTrip']);
Route::post('/trip/{trip}/stations', [TripController::class, 'attachStationToTrip']);
Route::post('/trip/search', [TripController::class, 'search']);
Route::post('/trip/filter', [TripController::class, 'filter']);
Route::post('/trip/{trip_id}/activate', [TripController::class, 'activate']);
Route::post('/trip/changeGuide/{active_id}', [TripController::class, 'updateUserInTrip']);


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});





