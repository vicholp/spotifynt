<?php

namespace App\Console\Commands;

use App\Jobs\ReloadArtJob;
use App\Models\Release;
use Illuminate\Console\Command;

class ReloadArtCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reload-art {--all : Reload all cover arts}';

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
        if ($this->option('all')) {
            $this->info('All cover arts have been reloaded.');

            Release::all()->each(function ($release) {
                ReloadArtJob::dispatch($release);
            });
        } else {
            $this->info('Cover arts have been reloaded for all releases.');
        }
    }
}
