<?php

namespace App\Jobs;

use App\Models\File;
use App\Services\Api\TaggerService;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class LoadFileInfoJob implements ShouldQueue
{
    use Batchable;
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected File $file,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(TaggerService $taggerService): void
    {
        if ($this->batch()?->cancelled()) {
            // The batch has been cancelled...

            return;
        }

        $fileInfo = $taggerService->getInfo($this->file->path);

        if (empty($fileInfo)) {
            Log::error('LoadFileInfoJob: No file info found for file: ' . $this->file->path);
            return;
        }

        $this->file->update([
            ...$fileInfo['info']
        ]);
    }
}
