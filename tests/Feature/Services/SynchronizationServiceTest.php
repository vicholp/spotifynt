<?php

use App\Models\Artist;
use App\Models\ReleaseGroup;
use App\Models\Server;
use App\Services\Api\MusicBrainzService;
use App\Services\SynchronizationService;
use Mockery\MockInterface;


test('sync artist', function () {
    $artist = [
        'id' => '1',
        'name' => 'Artist',
        'type' => 'a',
        'country' => 'US',
    ];

    $musicBrainzServiceMock = Mockery::mock(MusicBrainzService::class, function (MockInterface $mock) use ($artist) {
        $mock->shouldReceive([
            'getArtist' => $artist,
        ])
        ->with('id')
        ->once();
    });

    expect((new SynchronizationService($musicBrainzServiceMock))->syncArtist('id'))->toBeObject();
});

test('sync release group', function () {
    $releaseGroup = [
        'id' => '1',
        'title' => 'Release Group',
        'primary-type' => 'a',
        'artist-credit' => [
            [
                'artist' => [
                    'id' => '1'
                ]
            ]
        ]
    ];

    $musicBrainzServiceMock = Mockery::mock(MusicBrainzService::class, function (MockInterface $mock) use ($releaseGroup) {
        $mock->shouldReceive([
            'getReleaseGroup' => $releaseGroup,
        ])
        ->with('id')
        ->once();
    });

    $syncronizationService = Mockery::mock(SynchronizationService::class, [$musicBrainzServiceMock], function (MockInterface $mock) use ($musicBrainzServiceMock) {
        $mock->shouldReceive([
            'syncArtist' => Artist::factory()->create(),
        ]);
    })->makePartial();


    expect($syncronizationService->syncReleaseGroup('id'))->toBeObject();
}
);
