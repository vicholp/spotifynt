<?php

use App\Http\Controllers\Api\AlbumController;
use App\Http\Controllers\Api\ArtistController;
use App\Http\Controllers\Api\StatController;
use App\Http\Controllers\Api\TrackController;
use App\Http\Controllers\Api\QueryController;
use App\Http\Controllers\Api\RecommendationController;

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

Route::get('query', [QueryController::class, 'query']);

//Route::apiResource('played-track-stats', PlayedTrackStatController::class);
Route::post('stats/played-track', [StatController::class, 'TrackPlayed']);
Route::post('stats/now-playing', [StatController::class, 'NowPlaying']);
Route::apiResource('artists', ArtistController::class);

Route::get('recommendations/albums', [RecommendationController::class, 'albums']);
Route::apiResource('albums', AlbumController::class);
Route::apiResource('tracks', TrackController::class);

