<?php

use App\Models\Server;
use App\Models\User;
use App\Services\Api\BeetsService;

test('get albums', function () {
    $user = User::factory()->create();

    $server = Server::create([
        'name' => 'sakdjf',
        'path' => 'http://beets.vicholp.duckdns.org:80',
        'owner_id' => $user->id,
    ]);

    $beets = new BeetsService($server);

    dd($beets->getAlbums());
});
