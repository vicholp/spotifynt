<?php

use App\Events\UserPlayingStatusUpdatedEvent;
use App\Http\Controllers\AlphaPluginController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DiscoverController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\RecordingController;
use App\Http\Controllers\ReleaseController;
use App\Http\Controllers\ReleaseGroupController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\UploadFileController;
use App\Http\Resources\PlayingStatusResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::post('upload', UploadFileController::class)->name('upload.file');

    Route::get('recommendations', [RecommendationController::class, 'random']);
    Route::post('recommendations/playlist', [RecommendationController::class, 'playlist']);

    Route::get('search', SearchController::class)->name('search');

    Route::get('discover', DiscoverController::class)
        ->name('discover');

    Route::get('me/playing-status', function (Request $request) {
        $status = $request->user()->userPlayingStatus;

        return PlayingStatusResource::make($status);
    })->name('me.playing-status');

    Route::post('me/playing-status', function (Request $request) {
        $data = $request->validate([
            'player_state' => 'required',
        ]);

        $status = $request->user()->userPlayingStatus()->updateOrCreate(
            [],
            ['player_state' => $data['player_state']]
        );

        broadcast(new UserPlayingStatusUpdatedEvent($status))->toOthers();

        return PlayingStatusResource::make($status);
    })->name('me.playing-status.update');

    Route::get('alpha/artist/{id}', [AlphaPluginController::class, 'artist'])
        ->name('alpha.artist');
    Route::get('alpha/album/{id}', [AlphaPluginController::class, 'album'])
        ->name('alpha.album');
    Route::post('alpha/album/{id}/download', [AlphaPluginController::class, 'downloadAlbum'])
        ->name('alpha.album.download');
    Route::post('alpha/album/{albumId}/track/{trackId}/download', [AlphaPluginController::class, 'downloadTrack'])
        ->name('alpha.album.track.download');

    Route::apiResources(
        [
            'recordings' => RecordingController::class,
            'files' => FileController::class,
            'artists' => ArtistController::class,
            'releases' => ReleaseController::class,
            'release-groups' => ReleaseGroupController::class,
            'tracks' => TrackController::class,
        ]
    );

    Route::apiResource('devices', DeviceController::class)->except(['update']);
});
