<?php

namespace Database\Factories;

use App\Models\Release;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Track>
 */
class TrackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'release_id' => Release::factory(),
            'mb_recording_id' => $this->faker->uuid(),
            'title' => $this->faker->title(),
            'mb_data' => '{}',
        ];
    }
}
