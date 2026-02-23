<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'name' => $this->faker->firstName(),
        'hunger' => 100,
        'health' => 100,
        'energy' => 100,
        'cleanliness' => 100,
        'happiness' => 100,
    ];
}

}
