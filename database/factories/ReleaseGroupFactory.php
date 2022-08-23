<?php

namespace Database\Factories;

use App\Models\Artist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReleaseGroup>
 */
class ReleaseGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'artist_id' => Artist::factory(),
            'mb_releasegroup_id' => $this->faker->uuid(),
            'title' => $this->faker->title(),
            'type' => $this->faker->randomElement(['a', 'b']),
            'mb_data' => '{}',
        ];
    }
}
