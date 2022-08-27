<?php

namespace App\Services;

use App\Models\Release;
use App\Services\Api\CoverArtService;
use Illuminate\Support\Facades\Storage as Storage;

/**
 * Class ArtService
 * @package App\Services
 */
class ArtService
{
    public function __construct(
        private CoverArtService $coverArtService = new CoverArtService)
    {
        //
    }
    public function getUrl(Release $release): string
    {
        return config('APP_URL') . '/art/' . $release->mb_release_id . '.jpeg';
    }

    public function syncArt(Release $release): null|string
    {
        $image = $this->coverArtService->getArt($release);

        if (!$image) {
            return null;
        }

        imagejpeg($image, Storage::disk('art')->path($release->mb_release_id . '.jpeg'));
        imagetruecolortopalette($image, true, 1);
        $rgb = imagecolorat($image, 10, 10);

        if (!$rgb) {
            return null;
        }

        $colors = imagecolorsforindex($image, $rgb);
        $color = sprintf("#%02x%02x%02x", $colors['red'], $colors['green'], $colors['blue']);

        $release->main_color = $color;
        $release->save();

        dump($color);

        return $color;
    }
}
