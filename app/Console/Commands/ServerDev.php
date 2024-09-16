<?php

namespace App\Console\Commands;

use App\Models\Server;
use App\Models\ServerUser;
use App\Models\User;
use Illuminate\Console\Command;

class ServerDev extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server:dev';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a default server for development and attach it to the admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::whereEmail('admin@example.com')->firstOrFail();

        Server::create([
            'name' => 'Default',
            'path' => 'http://beets:9090',
            'owner_id' => $user->id,
        ]);

        ServerUser::create([
            'server_id' => 1,
            'user_id' => $user->id,
            'permissions' => 'admin',
        ]);
    }
}
