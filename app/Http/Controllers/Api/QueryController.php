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
        return [
            'albums' => AlbumSimpleResource::collection(Album::search($request->arg)->get()),
            'tracks' => TrackSimpleResource::collection(Track::search($request->arg)->get()),
        ];
    }
}
