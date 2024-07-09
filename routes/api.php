<?php

use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\ReleaseController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Server\TrackController as ServerTrackController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\User\ServerController as UserServerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/me', [UserController::class, 'me']);
    Route::apiResource('users', UserController::class);

    Route::get('recommendations/index', [RecommendationController::class, 'getIndexRecommendations']);
    Route::apiResource('users.servers', UserServerController::class);

    Route::get('search', SearchController::class);

    Route::apiResource('tracks', TrackController::class);
    Route::apiResource('releases', ReleaseController::class);

    Route::apiResource('servers.tracks', ServerTrackController::class);
});
