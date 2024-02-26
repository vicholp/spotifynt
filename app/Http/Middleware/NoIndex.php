<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Spatie\RobotsMiddleware\RobotsMiddleware;

class NoIndex extends RobotsMiddleware
{
    protected function shouldIndex(Request $request): bool
    {
        if ('production' != config('app.actual_env')) {
            return false;
        }

        return true;
    }
}
