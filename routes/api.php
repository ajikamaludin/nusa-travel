<?php

use App\Http\Controllers\Api\AgentController;
use App\Http\Controllers\Api\CarRentalController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\FastboatController;
use App\Http\Controllers\Api\FastboatPlaceController;
use App\Http\Controllers\Api\FastboatTrackController;
use App\Http\Controllers\Api\GlobaltixController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Website\OrderController;
use App\Http\Middleware\AuthenticateToken;
use App\Services\EkajayaService;
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

Route::get('/', fn () => ['app_name' => EkajayaService::key]);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// general purpose
Route::get('/roles', [RoleController::class, 'index'])->name('api.role.index');
Route::get('/fastboat/places', [FastboatPlaceController::class, 'index'])->name('api.fastboat.place.index');
Route::get('/tags', [TagController::class, 'index'])->name('api.tag.index');
Route::get('/fastboats', [FastboatController::class, 'index'])->name('api.fastboat.index');
Route::get('/agent', [AgentController::class, 'index'])->name('api.agent.index');
Route::get('/fastboat/tracks', [FastboatTrackController::class, 'index'])->name('api.fasboat.track.index');
Route::get('/car-rentals', [CarRentalController::class, 'index'])->name('api.car-rentals.index');
Route::get('/customers', [CustomerController::class, 'index'])->name('api.customer.index');

// globaltix
Route::get('/globaltix/tracks', [GlobaltixController::class, 'tracks'])->name('api.globaltix.track');
Route::get('/globaltix/products', [GlobaltixController::class, 'products'])->name('api.globaltix.product');
Route::get('/globaltix/options', [GlobaltixController::class, 'options'])->name('api.globaltix.option');

// for payment
Route::put('/carts/process-payment/{order}', [OrderController::class, 'payment_update'])->name('api.order.update');
Route::post('/notification-payment', [OrderController::class, 'payment_notification'])->name('api.notification.payment');

// api for agents
Route::middleware([AuthenticateToken::class])->group(function () {
    Route::get('/pickups', [AgentController::class, 'pickups']);
    Route::get('/tracks', [AgentController::class, 'tracks']);
    Route::post('/order', [AgentController::class, 'order']);
});
