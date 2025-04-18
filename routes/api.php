<?php

use App\Http\Controllers\Api\PlanetStatusController;
use App\Http\Controllers\Api\PlanetCampaignController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/planet/{planet_index}', [PlanetStatusController::class, 'index']);

Route::get('/planet/{planet_index}/history', [PlanetStatusController::class, 'planetHistory']);

Route::get('/planets', [PlanetStatusController::class, 'planetsAtTime']);

Route::get('/planets/active', [PlanetStatusController::class, 'activeCampaigns']);

Route::get('/campaigns', [PlanetCampaignController::class, 'index']);

Route::get('/campaigns/active', [PlanetCampaignController::class, 'active']);

Route::get('/players', [PlanetStatusController::class, 'playersGlobal']);
