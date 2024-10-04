<?php

use App\Models\Release;
use App\Models\User;

describe('get release', function () {
    test('get release with tracks', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        $release = Release::factory()->hasTracks(3)->create();

        $response = $this->getJson(route('api.releases.show', ['release' => $release->id, 'with_tracks' => true]));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'tracks',
                'art',
            ],
        ]);
    });

    test('get release', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        $release = Release::factory()->create();

        $response = $this->getJson(route('api.releases.show', ['release' => $release->id]));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
            ],
        ]);
    });
});
