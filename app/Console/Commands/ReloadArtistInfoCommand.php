<?php

namespace App\Console\Commands;

use App\Jobs\LoadArtistInfoJob;
use App\Models\Artist;
use Illuminate\Console\Command;

class ReloadArtistInfoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reload-artist-info-command {--all : Reload all artist information}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reload artist information from external sources';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $artists = Artist::get();

        foreach ($artists as  $artist) {
            LoadArtistInfoJob::dispatch($artist);
        }
    }
}
