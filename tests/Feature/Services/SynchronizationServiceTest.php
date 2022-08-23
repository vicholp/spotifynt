<?php

use App\Models\Server;
use App\Services\SynchronizationService;

test('example', function () {
    $server = Server::create([
        'name' => 'test',
        'path' => 'http://192.168.1.5:9000',
        'owner_id' => 1,
    ]);

    (new SynchronizationService())->syncServer($server);
});
