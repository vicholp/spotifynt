<?php

use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\ReleaseController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Server\ArtistController as ServerArtistController;
use App\Http\Controllers\Server\ReleaseController as ServerReleaseController;
use App\Http\Controllers\Server\ReleaseGroupController as ServerReleaseGroupController;
use App\Http\Controllers\Server\TrackController as ServerTrackController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\User\ServerController as UserServerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->name('api.')->group(function () {
    Route::get('/users/me', [UserController::class, 'me']);
    Route::apiResource('users', UserController::class);

    Route::get('recommendations/index', [RecommendationController::class, 'getIndexRecommendations'])
        ->name('recommendations.index');
    Route::apiResource('users.servers', UserServerController::class);

    Route::get('search', SearchController::class)->name('search');

    Route::apiResource('tracks', TrackController::class);
    Route::apiResource('releases', ReleaseController::class);

    Route::apiResource('servers.artists', ServerArtistController::class);
    Route::apiResource('servers.releases', ServerReleaseController::class);
    Route::apiResource('servers.release-groups', ServerReleaseGroupController::class);
    Route::apiResource('servers.tracks', ServerTrackController::class);
    Route::apiResource('servers', ServerController::class);

    Route::post('stats/played-track', [StatsController::class, 'storePlayedTrack'])->name('stats.played-track');
});
