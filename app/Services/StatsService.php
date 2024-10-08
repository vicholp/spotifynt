<?php

namespace App\Services;

use App\Models\PlayedTrackStat;
use App\Models\Release;
use App\Models\SearchedTermStat;
use App\Models\Server;
use App\Models\ShowedReleaseStat;
use App\Models\Track;
use App\Models\User;
use App\Services\Api\ListenBrainzService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

/**
 * Class StatsService.
 */
class StatsService
{
    public function storePlayedTrack(User $user, Server $server, Track $track, Carbon $time): void
    {
        PlayedTrackStat::create([
            'created_at' => $time,
            'user_id' => $user->id,
            'track_id' => $track->id,
            'server_id' => $server->id,
        ]);

        // (new ListenBrainzService($user))->submitListens($track, $release, $time);
    }

    public static function newSearchedTerm(User $user, string $term): void
    {
        SearchedTermStat::create([
            'term' => $term,
            'user_id' => $user->id,
        ]);
    }

    public static function newShowedRelease(User $user, Release $release, string $where): void
    {
        ShowedReleaseStat::create([
            'user_id' => $user->id,
            'release_id' => $release->id,
            'where' => $where,
        ]);
    }

    /**
     * @param Collection<(int|string),Release> $releases
     */
    public static function newShowedReleases(User $user, $releases, string $where): void
    {
        foreach ($releases as $release) {
            static::newShowedRelease($user, $release, $where);
        }
    }
}
