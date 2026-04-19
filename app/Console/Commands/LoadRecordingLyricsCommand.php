<?php

namespace App\Console\Commands;

use App\Jobs\LoadRecordingLyricsJob;
use App\Models\Recording;
use Illuminate\Console\Command;

class LoadRecordingLyricsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-recording-lyrics-command  {recording_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $recordingId = $this->argument('recording_id');

        if ($recordingId) {
            $recording = Recording::find($recordingId);

            LoadRecordingLyricsJob::dispatch($recording);

            return;
        }

        $recordings = Recording::all();

        foreach ($recordings as $recording) {
            LoadRecordingLyricsJob::dispatch($recording);
        }

        $this->info('Command executed successfully.');
    }
}
