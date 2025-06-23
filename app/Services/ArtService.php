<?php

namespace App\Services;

use App\Jobs\Art\MinimizeArtJob;
use App\Jobs\Art\UploadArtJob;
use App\Jobs\RemoveTempFileJob;
use App\Models\Art;
use App\Models\Release;
use App\Services\Api\CoverArtService;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use stefangabos\Zebra_Image\Zebra_Image;

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
        private CoverArtService $coverArtService = new CoverArtService(),
    ) {
        //
    }

    public function clearArt(): void
    {
        $art = Art::all();

        foreach ($art as $item) {
            if ($item->url) {
                Storage::delete($item->url);
            }
            $item->delete();
        }
    }

    public function getUrl(Release $release, int $size = 0, string $format = 'jpeg'): string
    {
        $art = Art::whereReleaseId($release->id)
            ->whereType('cover')
            ->whereWidth($size)
            ->whereHeight($size)
            ->whereMimeType('image/'.$format)
            ->first();

        if (!$art?->url) {
            return '';
        }

        return Storage::url($art->url);
    }

    public function uploadArt(string $fileName, Art $art): void
    {
        $name = "art/{$art->type}/{$art->release->id}/{$fileName}";

        Storage::put(
            $name,
            Storage::disk('temp')->get($fileName), // @phpstan-ignore argument.type
            'public'
        );

        $art->update([
            'url' => $name,
        ]);
    }

    public function syncArt(Release $release): void // @phpcs:ignore
    {
        if ($release->arts->count() > 0) {
            Log::debug('✅ Release '.$release->id.' already has art, skipping sync.');

            return;
        }

        $image = $this->coverArtService->getArt($release);

        if (!$image) {
            Log::debug('❌ No image found for release '.$release->id);

            return;
        }

        $originalName = Str::uuid().'.jpeg';

        $path = Storage::disk('temp')->path($originalName);

        Log::debug('Saving image to '.$path);

        imagejpeg($image, $path);

        $this->setMainColorRelease($image, $release);

        Log::debug('🔍 Minimizing images');

        foreach ($this->minimizeSizes as $size) {
            foreach ($this->minimizeFormats as $format) {
                $name = Str::uuid().'.'.$format;
                $targetPath = Storage::disk('temp')->path($name);

                Bus::chain([
                    new MinimizeArtJob($path, $targetPath, $size[0], $size[1]),
                    new UploadArtJob(
                        $name,
                        Art::updateOrCreate([
                            'release_id' => $release->id,
                            'type' => 'cover',
                            'width' => $size[0],
                            'height' => $size[1],
                            'mime_type' => 'image/'.$format,
                        ], [])
                    ),
                    new RemoveTempFileJob($name),
                ])->onQueue('default')->dispatch();
            }
        }
    }

    public function setMainColorRelease(\GdImage $image, Release $release): void
    {
        imagetruecolortopalette($image, true, 1);
        $rgb = imagecolorat($image, 10, 10);

        if (!$rgb) {
            return;
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
        int $quality = 80,
    ): bool {
        $image = new Zebra_Image();

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
