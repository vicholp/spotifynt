<?php

namespace App\Services;

use App\Jobs\Art\MinimizeArtJob;
use App\Jobs\Art\UploadArtJob;
use App\Jobs\RemoveTempFileJob;
use App\Models\Release;
use App\Models\ReleaseArt;
use App\Services\Api\BeetsService;
use App\Services\Api\CoverArtService;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        0 => [0, 0],
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
        $name = "art/cover/{$release->id}/{$size}x{$size}.{$format}";

        return Storage::disk('s3')->url(
            $name,
        );

        // if (0 == $size) {
        //     return config('APP_URL').'/art/'.$release->mb_release_id.'.'.$format;
        // }

        // return config('APP_URL').'/art/'.$release->mb_release_id.'-'.$size.'x'.$size.'.'.$format;
    }

    public function uploadArt($fileName, ReleaseArt $releaseArt): void
    {
        $name = "art/{$releaseArt->type}/{$releaseArt->release->id}/{$fileName}";

        Storage::disk('s3')->put(
            $name,
            Storage::disk('temp')->get($fileName),
            'public'
        );

        $releaseArt->update([
            'url' => $name,
        ]);
    }

    public function syncArt(Release $release, ?BeetsService $beetsService): void
    {
        $image = $this->coverArtService->getArt($release, $beetsService);

        if (!$image) {
            return;
        }

        $originalName = Str::uuid().'.jpeg';

        $path = Storage::disk('temp')->path($originalName);

        Log::debug('Saving image to '.$path);

        imagejpeg($image, $path);

        foreach ($this->minimizeSizes as $size) {
            foreach ($this->minimizeFormats as $format) {
                $name = $size[0].'x'.$size[1].'.'.$format;
                $targetPath = Storage::disk('temp')->path($name);

                Log::debug('Minimizing image to '.$targetPath);

                Bus::chain([
                    new MinimizeArtJob($path, $targetPath, $size[0], $size[1]),
                    new UploadArtJob(
                        $name,
                        ReleaseArt::create([
                            'release_id' => $release->id,
                            'type' => 'cover',
                            'width' => $size[0],
                            'height' => $size[1],
                            'mime_type' => 'image/'.$format,
                        ])
                    ),
                    new RemoveTempFileJob($name),
                ])->onQueue('low')->dispatch();
            }
        }

        $this->setMainColorRelease($image, $release);

        RemoveTempFileJob::dispatch($originalName);
    }

    public function setMainColorRelease($image, Release $release)
    {
        imagetruecolortopalette($image, true, 1);
        $rgb = imagecolorat($image, 10, 10);

        if (!$rgb) {
            return null;
        }

        $colors = imagecolorsforindex($image, $rgb);
        $color = sprintf('#%02x%02x%02x', $colors['red'], $colors['green'], $colors['blue']);

        $release->main_color = $color;
        $release->save();
    }

    public function minimizeArt(
        string $sourcePath,
        string $targetPath,
        int $height,
        int $width,
        int $quality = 80
    ): bool {
        $image = new \Zebra_Image();

        $image->source_path = $sourcePath;
        $image->target_path = $targetPath;

        $image->webp_quality = $quality;
        $image->jpeg_quality = $quality;

        $image->preserve_aspect_ratio = true;

        if (!$image->resize($width, $height)) {
            throw new \Exception('Failed to resize image: '.$image->error);
        }

        return true;
    }
}
