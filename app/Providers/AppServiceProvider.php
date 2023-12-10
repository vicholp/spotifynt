<?php

namespace App\Providers;

use App\Models\Artist;
use App\Models\Release;
use App\Models\Track;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Track::disableSearchSyncing();
        Release::disableSearchSyncing();
        Artist::disableSearchSyncing();
    }
}
