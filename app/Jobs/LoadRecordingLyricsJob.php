<?php

namespace App\Jobs;

use App\Models\Recording;
use App\Services\Api\LrclibService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class LoadRecordingLyricsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Recording $recording,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(LrclibService $lrclibService): void
    {
        $r = $lrclibService->getLyrics($this->recording);

        Log::info('Lrclib service: getLyrics result', [
            'recording_id' => $this->recording->id,
            'result' => $r,
        ]);

        if ($r) {
            $this->recording->lyrics = $r['plainLyrics'] ?? null;
            $this->recording->syncedLyrics = $r['syncedLyrics'] ?? null;
            $this->recording->instrumental = $r['instrumental'] ?? false;
            $this->recording->save();
        }
    }
}
