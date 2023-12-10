<?php

namespace App\Services\Seo;

use Illuminate\Support\Str;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

/**
 * Class Sitemap.
 */
class Sitemap
{
    // url containing those words will be omited
    private array $hiddenUrls = ['admin', 'login', 'logout', 'page'];

    // crawl site and write to sitemap
    public function create(): bool
    {
        SitemapGenerator::create(config('app.url'))
            ->hasCrawled(function (Url $url) {
                if (Str::contains($url->url, $this->hiddenUrls)) {
                    return;
                }

                return $url;
            })
            ->writeToFile(public_path('sitemap.xml'));

        return true;
    }
}
