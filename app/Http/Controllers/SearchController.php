<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArtistCollection;
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

        $artistIds = Artist::search($query)->keys();
        $releaseIds = Release::search($query)->keys();
        $trackIds = Track::search($query)->keys();

        $artists = Artist::with(['releases', 'releases.arts'])->whereIn('id', $artistIds)->limit(10)->get();
        $releases = Release::with(['arts'])->whereIn('id', $releaseIds)->limit(10)->get();
        $tracks = Track::with(['release', 'release.arts'])->whereIn('id', $trackIds)->limit(10)->get();

        return response()->json([
            'artists' => new ArtistCollection($artists),
            'albums' => new ReleaseCollection($releases),
            'tracks' => new TrackCollection($tracks),
        ]);
    }
}
