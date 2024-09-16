<?php

use App\Jobs\Stats\StorePlayedTrackJob;
use App\Models\User;
use Illuminate\Support\Carbon;

describe('store played track', function () {
    test('it should dispatch a job', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        Queue::fake();

        $this->freezeTime();

        $response = $this->postJson(route('api.stats.played-track'), [
            'user_id' => 1,
            'server_id' => 1,
            'track_id' => 1,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'OK',
        ]);

        Queue::assertPushedOn('low', StorePlayedTrackJob::class, function ($job) {
            return 1 === $job->userId
                && 1 === $job->serverId
                && 1 === $job->trackId
                && Carbon::now()->equalTo($job->time);
        });
    });
});
