<?php

use App\Http\Controllers\BookStationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GuidesDetailsController;
use App\Http\Controllers\ReservationController;
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

Route::apiResource('station', StationController::class);
Route::apiResource('trip', TripController::class);

Route::apiResource('user', UserController::class);
Route::apiResource('comment', CommentController::class);
Route::apiResource('reserve', ReservationController::class);
Route::apiResource('bookStation', bookStationController::class);
Route::post('/trip/{trip_id}', [TripController::class, 'tripById']);
Route::get('/rate-app', [CommentController::class,'redirectToGooglePlay']);
Route::get('/allTripsForUser/{user}', [TripController::class,'allTripsForUser']);// all trips for a user





Route::get('/trip/{trip}/stations', [TripController::class, 'allStationsForTrip']);
Route::post('/trip/search', [TripController::class, 'search']);
Route::post('/trip/filter', [TripController::class, 'filter']);
Route::post('/trip/payInPerson/{active_id}', [TripController::class, 'payInPerson']);
Route::post('/user/payWithBank', [UserController::class, 'payWithBank']);


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

Route::middleware('checkAdminRole')->group(function () {

    Route::put('/trip/{trip}', [TripController::class, 'update']);
    Route::post('/trip', [TripController::class, 'store']);
    Route::delete('/trip/{trip}', [TripController::class, 'destroy']);

    Route::delete('/comment/{comment}', [TripController::class, 'destroy']);
    Route::post('/guidesDetails', [GuidesDetailsController::class, 'create']);
    Route::controller(UserController::class)->group(function () {
        Route::get('getAllGuides', 'getAllGuides');
        Route::get('getAllCustomers', 'getAllCustomers');
    });

    Route::post('/trip/changeGuide/{active_id}', [TripController::class, 'updateUserInTrip']);//change  the guide of a trip
    Route::apiResource('stationTrip', StationTripController::class);
    Route::post('/trip/{trip}/stations', [TripController::class, 'attachStationToTrip']);
    Route::post('/trip/{trip_id}/activate', [TripController::class, 'activate']);

    Route::get('/trip/allUsersForTrip/{trip}', [TripController::class, 'allUsersForTrip']);
});

Route::middleware('checkGuideRole')->group(function () {
    Route::get('/trip/allTripForGuide/{guide_id}', [TripController::class, 'allTripForGuide']);

});
