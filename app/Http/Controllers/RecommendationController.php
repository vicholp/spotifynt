<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReleaseCollection;
use App\Models\Release;
use App\Services\StatsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function getIndexRecommendations(): JsonResponse
    {
        $albums = Release::limit(6)->inRandomOrder()->get();

        if (Auth::check()) {
            StatsService::newShowedReleases(Auth::user(), $albums, 'index');  // @phpstan-ignore-line
        }

        return response()->json([
            'albums' => new ReleaseCollection($albums),
        ]);
    }
}
