<?php

namespace App\Services;

use App\Models\Release;
use App\Models\SearchedTermStat;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class StatsService
 * @package App\Services
 */
class StatsService
{
    public static function newShowedRelease(User $user, Release $release): void
    {
        $release->showedReleaseStats()->create([
            'where' => 'random',
            'user_id' => $user->id,
        ]);
    }

    /**
     * @param Collection<(int|string),Release> $releases
     */
    public static function newShowedReleases(User $user, $releases): void
    {
        foreach ($releases as $release) {
            self::newShowedRelease($user, $release);
        }
    }

    public static function newSearchedTerm(User $user, string $term): void
    {
        SearchedTermStat::create([
            'term' => $term,
            'user_id' => $user->id,
        ]);
    }
}
