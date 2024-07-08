<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/me', [UserController::class, 'me']);
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
