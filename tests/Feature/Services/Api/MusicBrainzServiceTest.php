<?php

use App\Services\Api\MusicBrainzService;

test('get artist from cache', function () {
    $artist_id = '7416e707-94b5-3810-b6b8-4229ab2182ec';

    Cache::shouldReceive('remember')
        ->once()
        ->with('mb_artist_'.$artist_id, Mockery::any(), Mockery::any())
        ->andReturn(['foo' => 'bar']);

    $artist = (new MusicBrainzService())->getArtist($artist_id);
    expect($artist)->toHaveKey('foo', 'bar');
});

test('get release from cache', function () {
    $release_id = 'f8f8f8f8-f8f8-f8f8-f8f8-f8f8f8f8f8f8';

    Cache::shouldReceive('remember')
        ->once()
        ->with('mb_release_'.$release_id, Mockery::any(), Mockery::any())
        ->andReturn(['foo' => 'bar']);

    $release = (new MusicBrainzService())->getRelease($release_id);
    expect($release)->toHaveKey('foo', 'bar');
});

test('get release group from cache', function () {
    $release_group_id = 'f8f8f8f8-f8f8-f8f8-f8f8-f8f8f8f8f8f8';

    Cache::shouldReceive('remember')
        ->once()
        ->with('mb_releasegroup_'.$release_group_id, Mockery::any(), Mockery::any())
        ->andReturn(['foo' => 'bar']);

    $release_group = (new MusicBrainzService())->getReleaseGroup($release_group_id);
    expect($release_group)->toHaveKey('foo', 'bar');
});

test('get recording from cache', function () {
    $recording_id = 'f8f8f8f8-f8f8-f8f8-f8f8-f8f8f8f8f8f8';

    Cache::shouldReceive('remember')
        ->once()
        ->with('mb_recording_'.$recording_id, Mockery::any(), Mockery::any())
        ->andReturn(['foo' => 'bar']);

    $recording = (new MusicBrainzService())->getRecording($recording_id);
    expect($recording)->toHaveKey('foo', 'bar');
}
);
