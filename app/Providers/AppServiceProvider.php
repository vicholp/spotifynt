<?php

namespace App\Providers;

use App\Models\Artist;
use App\Models\Release;
use App\Models\Track;
// use Dedoc\Scramble\Scramble;
// use Dedoc\Scramble\Support\Generator\OpenApi;
// use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Track::disableSearchSyncing();
        Release::disableSearchSyncing();
        Artist::disableSearchSyncing();

        // Scramble::routes(function (Route $route) {
        //     return Str::startsWith($route->uri, 'api/');
        // });

        // Scramble::extendOpenApi(function (OpenApi $openApi) {
        //     $openApi->secure(
        //         // SecurityScheme::http('bearer', 'JWT')
        //     );
        // });
    }
}
