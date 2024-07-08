<?php

use App\Http\Controllers\Api\ReleaseController;
use App\Http\Controllers\Api\ServerController;
use App\Http\Controllers\Api\ServerRecommendationController;
use App\Http\Controllers\Api\ServerTrackController;
use App\Http\Controllers\Api\StatsController;
use App\Http\Controllers\Api\TrackController;
use App\Http\Controllers\Api\UserServerController;
use App\Http\Controllers\HealthzController;
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

Route::get('/', HealthzController::class);

Route::middleware('auth')->group(function () {
    Route::view('player', 'main.player');

    Route::prefix('api')->group(function () {
        Route::prefix('servers/{server}/recommendations')->controller(ServerRecommendationController::class)->group(function () {
            Route::get('random', 'random');
        });

        Route::apiResource('tracks', TrackController::class);
        Route::get('server/{server}/searchContent', [ServerController::class, 'searchContent']);
        Route::apiResource('server', ServerController::class);
        Route::apiResource('users.servers', UserServerController::class);
        Route::apiResource('servers.tracks', ServerTrackController::class);
        Route::apiResource('releases', ReleaseController::class);
    });
});

Route::prefix('api/stats')->group(function () {
    Route::post('playedTrack', [StatsController::class, 'storePlayedTrack']);
});
