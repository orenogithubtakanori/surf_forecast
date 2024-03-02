<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\LocationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', function() {
    return view('surf_forecast/index');
});
Route::get('/prefectures', [AreaController::class, 'prefecture']);
Route::get('/areas/{area}', [AreaController::class, 'area']);
Route::get('/locations/{location}', [LocationController::class, 'location']);