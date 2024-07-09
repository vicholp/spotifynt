<?php

namespace App\Console\Commands;

use App\Models\Server;
use App\Models\User;
use Illuminate\Console\Command;

class AttachDefaultServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:attach-default-server {--default}';

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
        if ($this->option('default')) {
            $user = User::whereEmail('admin@example.com')->first();
        }

        Server::create([
            'name' => 'Default',
            'path' => 'http://beets:9090',
            'owner_id' => $user->id,
        ]);
    }
}
