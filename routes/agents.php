<?php

use App\Http\Controllers\Api\AgentController;
use App\Http\Controllers\Api\FastboatTrackController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'agent-api', 'middleware' => ['authoken']], function () {
    Route::get('/fastboat/tracks', [FastboatTrackController::class, 'index']);
    Route::get('/list-price-agent', [AgentController::class, 'listPriceAgent']);
    Route::post('order', [AgentController::class, 'orderAgent']);
});
