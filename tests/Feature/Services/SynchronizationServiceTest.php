<?php

use App\Models\Artist;
use App\Models\Release;
use App\Services\Api\MusicBrainzService;
use App\Services\SynchronizationService;
use Mockery\MockInterface;

test('sync track', function () {
    $release = Release::factory()->create();

    $recording = [
        'id' => '123',
        'title' => 'Test',
        'test' => 123,
    ];

    $musicBrainzServiceMock = Mockery::mock(MusicBrainzService::class, function (MockInterface $mock) use ($recording) {
        $mock->shouldReceive([
            'getRecording' => $recording,
        ])
        ->with('id')
        ->once();
    });

    $track = (new SynchronizationService($musicBrainzServiceMock))->syncTrack($release, 'id');

    expect($track->title)->toBe($recording['title']);
})->skip();

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

    $artist = (new SynchronizationService($musicBrainzServiceMock))->syncArtist('id'); // @phpstan-ignore-line

    expect($artist->name)->toBe($artist['name']);
})->skip();

test('sync release group', function () {
    $releaseGroup = [
        'id' => '1',
        'title' => 'Release Group',
        'primary-type' => 'a',
        'artist-credit' => [
            [
                'artist' => [
                    'id' => '1',
                ],
            ],
        ],
    ];

    $musicBrainzServiceMock = Mockery::mock(MusicBrainzService::class, function (MockInterface $mock) use ($releaseGroup) {
        $mock->shouldReceive([
            'getReleaseGroup' => $releaseGroup,
        ])
        ->with('id')
        ->once();
    });

    $syncronizationService = Mockery::mock(SynchronizationService::class, [$musicBrainzServiceMock], function (MockInterface $mock) {
        $mock->shouldReceive([
            'syncArtist' => Artist::factory()->create(),
        ]);
    })->makePartial();

    expect($syncronizationService->syncReleaseGroup('id'))->toBeObject();
})->skip();
