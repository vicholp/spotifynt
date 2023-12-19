<?php

namespace App\Services;

use App\Jobs\Art\MinimizeArtJob;
use App\Models\Release;
use App\Services\Api\BeetsService;
use App\Services\Api\CoverArtService;
use Illuminate\Support\Facades\Storage;

/**
 * Class ArtService.
 */
class ArtService
{
    private array $minimizeSizes = [
        1000 => [1000, 1000],
        500 => [500, 500],
        250 => [250, 250],
        75 => [75, 75],
    ];

    private array $minimizeFormats = [
        'jpeg',
        'webp',
    ];

    public function __construct(
        private CoverArtService $coverArtService = new CoverArtService()
    ) {
        //
    }

    public function getUrl(Release $release, int $size = 0, string $format = 'jpeg'): string
    {
        if ($size == 0) {
            return config('APP_URL').'/art/'.$release->mb_release_id.'.'.$format;
        }

        return config('APP_URL').'/art/'.$release->mb_release_id.'-'.$size.'x'.$size.'.'.$format;
    }

    public function syncArt(Release $release, ?BeetsService $beetsService): null|string
    {
        $image = $this->coverArtService->getArt($release, $beetsService);

        if (!$image) {
            return null;
        }

        $path = Storage::disk('art')->path($release->mb_release_id.'.jpeg');

        imagejpeg($image, $path);

        foreach ($this->minimizeSizes as $size) {
            foreach ($this->minimizeFormats as $format) {
                $target_path = Storage::disk('art')->path($release->mb_release_id.'-'.$size[0].'x'.$size[1].'.'.$format);
                MinimizeArtJob::dispatch($path, $target_path, $size[0], $size[1])->onQueue('low');
            }
        }

        $targetPath = Storage::disk('art')->path($release->mb_release_id.'.'.$format);
        MinimizeArtJob::dispatch($path, $targetPath, 0, 0)->onQueue('low');

        imagetruecolortopalette($image, true, 1);
        $rgb = imagecolorat($image, 10, 10);

        if (!$rgb) {
            return null;
        }

        $colors = imagecolorsforindex($image, $rgb);
        $color = sprintf('#%02x%02x%02x', $colors['red'], $colors['green'], $colors['blue']);

        $release->main_color = $color;
        $release->save();

        return $color;
    }

    public function minimizeArt(string $source_path, string $target_path, int $height, int $width, int $quality = 80): bool
    {
        $image = new \Zebra_Image();

        $image->source_path = $source_path;
        $image->target_path = $target_path;

        $image->webp_quality = $quality;
        $image->jpeg_quality = $quality;

        $image->preserve_aspect_ratio = true;

        if (!$image->resize($width, $height)) {
            throw new \Exception('Failed to resize image: '.$image->error);
        }

        return true;
    }
}
