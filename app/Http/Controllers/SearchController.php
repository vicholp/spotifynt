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

        return response()->json([
            'albums' => new ReleaseCollection(
                Release::search($query)
                    ->get()
            ),
            'tracks' => new TrackCollection(
                Track::search($query)->get()
            ),
        ]);
    }
}
