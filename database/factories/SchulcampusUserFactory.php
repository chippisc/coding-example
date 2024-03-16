<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SchulcampusUser>
 */
class SchulcampusUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'username' => fake()->userName(),
            'given_name' => fake()->firstName(),
            'family_name' => fake()->lastName(),
            'role' => 'student',
        ];
    }
}
