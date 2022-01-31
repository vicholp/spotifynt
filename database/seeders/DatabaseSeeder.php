<?php

namespace Database\Seeders;

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
        \App\Models\Artist::factory(10)
            ->has(\App\Models\Album::factory()
                ->count(rand(1,20))
                ->has(\App\Models\Track::factory()
                    ->count(rand(4,25))
                    )
                )
            ->create();
    }
}
