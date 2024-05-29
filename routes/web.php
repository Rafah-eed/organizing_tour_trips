<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/trip', [\App\Http\Controllers\TripController::class, 'add']);//->middleware('debug');
    Route::get('/trip/all', [\App\Http\Controllers\TripController::class, 'show']);
    Route::post('/trip/store', [\App\Http\Controllers\TripController::class, 'store']);
    Route::post('/trip/delete', [\App\Http\Controllers\TripController::class, 'delete']);
    Route::post('/trip/edit', [\App\Http\Controllers\TripController::class, 'edit']);
    Route::post('/trip/update', [\App\Http\Controllers\TripController::class, 'update']);
