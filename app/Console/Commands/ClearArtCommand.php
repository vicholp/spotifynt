<?php

namespace App\Console\Commands;

use App\Services\ArtService;
use Illuminate\Console\Command;

class ClearArtCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-art';

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
        (new ArtService())->clearArt();
    }
}
