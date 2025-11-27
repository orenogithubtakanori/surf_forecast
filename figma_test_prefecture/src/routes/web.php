<?php

use App\Http\Controllers\SurfController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// Surf Dashboard Routes
Route::get('/surf', [SurfController::class, 'index'])->name('surf.dashboard');
Route::get('/surf/prefecture', [SurfController::class, 'prefecture'])->name('surf.prefecture');
Route::get('/surf/spot/{id}', [SurfController::class, 'index'])->name('surf.spot.detail'); // 詳細ページ（後で実装）
Route::get('/api/surf/wave-data', [SurfController::class, 'getWaveData'])->name('surf.wave-data');
Route::get('/api/surf/spots', [SurfController::class, 'getSurfSpots'])->name('surf.spots');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';