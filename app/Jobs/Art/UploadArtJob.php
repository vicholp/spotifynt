<?php

namespace App\Jobs\Art;

use App\Models\ReleaseArt;
use App\Services\ArtService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadArtJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private string $fileName,
        private ReleaseArt $releaseArt
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new ArtService())->uploadArt($this->fileName, $this->releaseArt);
    }
}
