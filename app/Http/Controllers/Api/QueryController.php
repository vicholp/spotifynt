<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\AlbumSimpleResource;
use App\Http\Resources\TrackResource;
use App\Http\Resources\TrackSimpleResource;
use App\Models\Album;
use App\Models\Track;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    public function query(Request $request)
    {
        $album_constrain = Album::with('artist');
        $track_constrain = Track::with(['album', 'album.artist']);
        return [
            'albums' => AlbumSimpleResource::collection(Album::search($request->arg)->constrain($album_constrain)->get()),
            'tracks' => TrackSimpleResource::collection(Track::search($request->arg)->constrain($track_constrain)->get()),
        ];
    }
}
