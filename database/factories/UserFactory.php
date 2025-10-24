<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * This will return a faked User with some restrictions:
     *  - User email must be unique
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake() -> firstName(),
            'last_name' => fake() -> lastName(),
            'email' => fake() -> unique() -> safeEmail(),
            'administrator_flag' => false,
        ];
    }
}
