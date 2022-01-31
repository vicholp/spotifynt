<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RecommendationsService;

class RecommendationController extends Controller
{
    public function albums()
    {
        return RecommendationsService::getAlbums();
    }
}
