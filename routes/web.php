<?php

use App\Http\Controllers\AlphaPluginController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\DiscoverController;
use App\Http\Controllers\DownloadFinishController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\RecordingController;
use App\Http\Controllers\ReleaseController;
use App\Http\Controllers\ReleaseGroupController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\UploadFileController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::post('upload', UploadFileController::class)->name('upload.file');

    Route::get('recommendations', RecommendationController::class);

    Route::get('search', SearchController::class)->name('search');

    Route::get('discover', DiscoverController::class)
        ->name('discover');

    Route::get('alpha/artist/{id}', [AlphaPluginController::class, 'artist'])
        ->name('alpha.artist');
    Route::get('alpha/album/{id}', [AlphaPluginController::class, 'album'])
        ->name('alpha.album');
    Route::post('alpha/album/{id}/download', [AlphaPluginController::class, 'downloadAlbum'])
        ->name('alpha.album.download');

    Route::post('alpha/downloads/finish', DownloadFinishController::class)
        ->name('download.finish');

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
});
