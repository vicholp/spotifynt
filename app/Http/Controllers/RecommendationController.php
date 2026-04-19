<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReleaseCollection;
use App\Models\Release;
use App\Models\Track;
use App\Services\Api\RecService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RecommendationController extends Controller
{
    public function random(): JsonResponse
    {
        $albums = Release::limit(12)->inRandomOrder()->get();

        return response()->json([
            'albums' => new ReleaseCollection($albums),
        ], 201, [], JSON_UNESCAPED_SLASHES);
    }

    public function playlist(Request $request, RecService $recService): JsonResponse
    {
        $track_ids = $request->input('track_ids', []);

        $tracks = Track::whereIn('id', $track_ids)->get();

        $recordings = $tracks->map(function ($track) {
            return $track->recording;
        });

        $recommendations = $recService->recommendationForPlaylist($track_ids);

        return response()->json([
            'recommendations' => $recommendations,
        ], 201, [], JSON_UNESCAPED_SLASHES);
    }
}
