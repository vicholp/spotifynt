<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReleaseCollection;
use App\Models\Release;
use Illuminate\Http\JsonResponse;

class RecommendationController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $albums = Release::limit(12)->inRandomOrder()->get();

        return response()->json([
            'albums' => new ReleaseCollection($albums),
        ], 201, [], JSON_UNESCAPED_SLASHES);
    }
}
