<?php

namespace App\Jobs;

use App\Models\Recording;
use App\Services\Api\RecService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class LoadRecordingRecJob implements ShouldQueue
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
    public function handle(RecService $recService): void
    {
        $r = $recService->createRecording($this->recording);

        Log::info('Rec service: createRecording result', [
            'recording_id' => $this->recording->id,
            'result' => $r,
        ]);
    }
}
