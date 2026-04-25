<?php

namespace App\Console\Commands;

use App\Jobs\LoadRecordingRecJob;
use App\Models\Recording;
use Illuminate\Console\Command;

class LoadRecordingRecCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-recording-rec-command {recording_id?} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $recordingId = $this->argument('recording_id');
        $force = $this->option('force') ?? false;

        if ($recordingId) {
            $recording = Recording::find($recordingId);

            LoadRecordingRecJob::dispatch($recording, $force);

            return;
        }

        $recordings = Recording::all();

        foreach ($recordings as $recording) {
            LoadRecordingRecJob::dispatch($recording, $force);
        }

        $this->info('Command executed successfully.');
    }
}
