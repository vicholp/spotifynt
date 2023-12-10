<?php

namespace Database\Seeders;

use App\Models\Server;
use App\Models\Track;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Server::factory(3)->create();

        Track::factory(20)->create();
    }
}
