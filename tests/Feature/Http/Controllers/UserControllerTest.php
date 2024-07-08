<?php

use App\Models\User;

describe('Me route', function () {
    it('should return the authenticated user', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson('/api/users/me');

        $response->assertJson([
            'data' => $user->toArray(),
        ]);
    });
    it('should return 401 if not authenticated', function () {
        $response = $this->getJson('/api/users/me');

        $response->assertStatus(401);
    });
});
