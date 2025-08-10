<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReleaseCollection;
use App\Http\Resources\TrackCollection;
use App\Models\Artist;
use App\Models\Release;
use App\Models\Track;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate(['q' => 'required|string|max:255']);

        $query = $request->input('q');

        // this is needed to include artist's albums in results
        // $albums = Release::search($query)->get();  // @phpstan-ignore argument.type
        // $artists = Artist::search($query)->get();  // @phpstan-ignore argument.type

        // $albums = $albums->merge($artists->flatMap->releaseGroups->flatMap->releases->unique('id'));

        return response()->json([
            'albums' => new ReleaseCollection(
                // $albums,
                Release::all()
            ),
            'tracks' => new TrackCollection(
                // Track::search($query)->get()->load('release')  // @phpstan-ignore argument.type
                Track::all(),
            ),
        ]);
    }
}
