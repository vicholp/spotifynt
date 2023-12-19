<?php

namespace App\Jobs\Art;

use App\Services\ArtService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MinimizeArtJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private string $sourcePath,
        private string $targetPath,
        private int $height,
        private int $width,
        private int $quality = 80
    ) {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        (new ArtService())->minimizeArt(
            $this->sourcePath,
            $this->targetPath,
            $this->height,
            $this->width,
            $this->quality
        );
    }
}
