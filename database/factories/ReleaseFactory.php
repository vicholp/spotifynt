<?php

namespace Database\Factories;

use App\Models\ReleaseGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Release>
 */
class ReleaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'release_group_id' => ReleaseGroup::factory(),
            'mb_release_id' => $this->faker->uuid(),
            'title' => $this->faker->title(),
            'date' => $this->faker->date(),
            'country' => $this->faker->country(),
            'mb_data' => '{}',
        ];
    }
}
