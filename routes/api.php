<?php

use App\Http\Controllers\Api\RecommendationController;
use App\Http\Controllers\Api\ReleaseController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\Server\ServerTrackController;
use App\Http\Controllers\Api\ServerController;
use App\Http\Controllers\Api\TrackController;
use App\Http\Controllers\Api\User\UserServerController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('recommendations/index', [RecommendationController::class, 'getIndexRecommendations']);
    Route::get('search', SearchController::class);

    Route::get('users/me', [UserController::class, 'me']);

    Route::apiResource('tracks', TrackController::class);
    Route::get('server/{server}/searchContent', [ServerController::class, 'searchContent']);
    Route::apiResource('server', ServerController::class);
    Route::apiResource('users.servers', UserServerController::class);
    Route::apiResource('servers.tracks', ServerTrackController::class);
    Route::apiResource('releases', ReleaseController::class);
});
