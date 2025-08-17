<?php

namespace App\Console\Commands;

use App\Jobs\LoadFileInfoJob;
use App\Models\File;
use Illuminate\Console\Command;

class ReloadFileInfoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reload-file-info {--all : Reload all file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reload file information for all files or a specific file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $files = File::get();

        foreach ($files as $file) {
            LoadFileInfoJob::dispatch($file);
        }
    }
}
