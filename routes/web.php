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
use Illuminate\Http\Request;
use App\Models\User;

Route::post('/login', function (Request $request) {
        $fields = $request->validate([
            'username' => 'required|string|email',
            'password' => 'required|string'
        ]);

        // 1. Check email
        $user = User::where('email', $fields['username'])->first();

        // 2. Check password
        if (!$user || !\Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Invalid credentials'
            ], 401);
        }

        // 3. Generate the Passport JWT
        $token = $user->createToken('FrontendApp')->accessToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 200);
});

Route::post('api/alpha/downloads/finish', DownloadFinishController::class)
    ->name('download.finish');