<?php

use App\Models\PlayedTrackStat;
use App\Models\Release;
use App\Models\SearchedTermStat;
use App\Models\Server;
use App\Models\ShowedReleaseStat;
use App\Models\Track;
use App\Models\User;
use App\Services\StatsService;
use Illuminate\Support\Carbon;
use Mockery\MockInterface;

describe('storePlayedTrack', function () {
    it('should create a new PlayedTrackStat', function () {
        $user = User::factory()->create();
        $server = Server::factory()->create();
        $track = Track::factory()->create();
        $time = Carbon::now();

        (new StatsService())->storePlayedTrack($user, $server, $track, $time);

        $playedTrackStat = PlayedTrackStat::first();

        expect($playedTrackStat->user_id)->toBe($user->id);
        expect($playedTrackStat->track_id)->toBe($track->id);
        expect($playedTrackStat->server_id)->toBe($server->id);
        expect($playedTrackStat->created_at->timestamp)->toBe($time->timestamp);
    });
});

describe('newSearchedTerm', function () {
    it('should create a new SearchedTermStat', function () {
        $user = User::factory()->create();
        $term = 'term';

        StatsService::newSearchedTerm($user, $term);

        $searchedTermStat = SearchedTermStat::first();

        expect($searchedTermStat->term)->toBe($term);
        expect($searchedTermStat->user_id)->toBe($user->id);
    });
});

describe('newShowedRelease', function () {
    it('should create a new ShowedReleaseStat', function () {
        $user = User::factory()->create();
        $release = Release::factory()->create();
        $where = 'where';

        StatsService::newShowedRelease($user, $release, $where);

        $showedReleaseStat = ShowedReleaseStat::first();

        expect($showedReleaseStat->user_id)->toBe($user->id);
        expect($showedReleaseStat->release_id)->toBe($release->id);
        expect($showedReleaseStat->where)->toBe($where);
    });
});

describe('newShowedReleases', function () {
    it('should create a new ShowedReleaseStat for each release', function () {
        $user = User::factory()->create();
        $releases = Release::factory()->count(3)->create();
        $where = 'where';

        $mock = $this->partialMock(StatsService::class, function (MockInterface $mock) use ($where) {
            $mock->shouldReceive('newShowedRelease')
                ->times(3)
                ->with(Mockery::type(User::class), Mockery::type(Release::class), $where);
        });

        $mock->newShowedReleases($user, $releases, $where);
    });
});
