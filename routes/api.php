<?php

use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\FastboatPlaceController;
use App\Http\Controllers\Website\FastboatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/roles', [RoleController::class, 'index'])->name('api.role.index');
Route::get('/fastboat/places', [FastboatPlaceController::class, 'index'])->name('api.fastboat.place.index');
Route::post('/fastboat/{order}',[FastboatController::class, 'store'])->name('api.fastboat.store');
Route::put('/fastboat/{order}',[FastboatController::class, 'update'])->name('api.fastboat.update');

