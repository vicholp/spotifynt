<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReleaseCollection;
use App\Http\Resources\TrackCollection;
use App\Models\Release;
use App\Models\Track;
use App\Services\StatsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'q' => 'required|string',
        ]);

        if (Auth::check()) {
            StatsService::newSearchedTerm(Auth::user(), $request->q);
        }

        return [
            'albums' => new ReleaseCollection(
                Release::search($request->q)->get()
            ),
            'tracks' => new TrackCollection(
                Track::search($request->q)->get()->load('release')
            ),
        ];
    }
}
