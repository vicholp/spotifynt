<?php

use App\Jobs\Stats\StorePlayedTrackJob;
use App\Models\Server;
use App\Models\Track;
use App\Models\User;
use App\Services\StatsService;
use Illuminate\Support\Carbon;
use Mockery\MockInterface;

describe('store played track', function () {
    test('it should store the stats', function () {
        $user = User::factory()->create();
        $server = Server::factory()->create();
        $track = Track::factory()->create();

        $this->mock(StatsService::class, function (MockInterface $mock) {
            $mock->shouldReceive('storePlayedTrack')
                ->once()
                ->with(
                    Mockery::type(User::class),
                    Mockery::type(Server::class),
                    Mockery::type(Track::class),
                    Mockery::type(Carbon::class),
                );
        });

        StorePlayedTrackJob::dispatchSync(
            $user->id,
            $server->id,
            $track->id,
            Carbon::now(),
        );
    });
});
