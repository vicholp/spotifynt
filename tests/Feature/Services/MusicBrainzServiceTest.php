<?php

use App\Services\MusicBrainzService;
use MusicBrainz\Api\Core\Release;
use MusicBrainz\Client;

test('get release', function () {
    $mb = new MusicBrainzService();

    expect($mb->getRelese('47e4b780-7bce-4a3a-9206-1b682f985015'))->toHaveProperty('id', '47e4b780-7bce-4a3a-9206-1b682f985015');
});

// test('test', function () {
//     $client = new Client('TestApp', '1.1.0', 'contact@gmail.com');

//     $releaseApi = new Release($client);

//     $a = $releaseApi->lookup('47e4b780-7bce-4a3a-9206-1b682f985015', ['labels']);

//     echo $a;
// });
