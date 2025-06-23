<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\RecordingController;
use App\Http\Controllers\ReleaseController;
use App\Http\Controllers\ReleaseGroupController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\UploadFileController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
    Route::post('upload', UploadFileController::class)
    ->name('upload.file');

    Route::get('recommendations', RecommendationController::class);

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

Route::get('/', function () {
    return view('welcome');
});
