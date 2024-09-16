<?php

use App\Models\User;
use App\Services\StatsService;

describe('search', function () {
    test('search valid term', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->mock(
            StatsService::class,
            function ($mock) use ($user) {
                $mock->shouldReceive('newSearchedTerm')
                    ->once()
                    ->with($user, 'term');
            }
        );

        $response = $this->getJson(route('api.search', ['q' => 'term']));

        $response->assertOk();
        $response->assertJsonStructure([
            'albums',
            'tracks',
        ]);
    });

    test('search invalid term', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson(route('api.search', ['q' => '']));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('q');
    });
});
