<?php

use App\Http\Controllers\Api\FastboatController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\FastboatPlaceController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Website\OrderController;
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
Route::get('/tags', [TagController::class, 'index'])->name('api.tag.index');
Route::get('/fastboats', [FastboatController::class, 'index'])->name('api.fastboat.index');

// for payment
Route::put('/carts/process-payment/{order}', [OrderController::class, 'payment_update'])->name('api.order.update');
Route::post('/notification-payment', [OrderController::class, 'payment_notification'])->name('api.notification.payment');


