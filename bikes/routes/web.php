<?php

use App\Http\Controllers\PlacesController;
use App\Http\Controllers\TestController;
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

Route::get('/', [PlacesController::class, 'index'])->name('places');
Route::get('/nearest-place', [PlacesController::class, 'nearestPlace'])->name('nearest-place');

Route::get('test', [TestController::class, 'test']);
Route::get('nearest', [TestController::class, 'nearest']);
Route::get('all-places', [TestController::class, 'allPlaces']);
