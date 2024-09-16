<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReleaseCollection;
use App\Http\Resources\TrackCollection;
use App\Models\Release;
use App\Models\Track;
use App\Services\StatsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, StatsService $statsService): JsonResponse
    {
        $request->validate([
            'q' => 'required|string',
        ]);

        if (Auth::check()) {
            $statsService::newSearchedTerm(Auth::user(), $request->q);  // @phpstan-ignore argument.type, argument.type
        }

        return response()->json([
            'albums' => new ReleaseCollection(
                Release::search($request->q)->get() // @phpstan-ignore argument.type
            ),
            'tracks' => new TrackCollection(
                Track::search($request->q)->get()->load('release')  // @phpstan-ignore argument.type
            ),
        ]);
    }
}
