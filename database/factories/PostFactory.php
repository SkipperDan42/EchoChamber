<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * This will return a post with some restrictions:
     * - Post is from a random User (FK: user_id)
     * - Post can only be 'heard' by at most the number of users (set in Seeder, otherwise max=1)
     * - Post can only be echoed by at most a tenth of users (to reduce entries in DB)
     * - Post can only be clapped by at most half of users
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get heard from withUserCount Factory Helper Method using $this->attributes
        // otherwise fake it manually as 100
        $heard = $this -> attributes['heard'] ?? 100;

        // Get a random user by sorting table randomly and taking first ID
        $user_id = User::query() -> inRandomOrder() -> value('id');

        return [
            'user_id' => $user_id,
            'title' => fake() -> sentence(),
            'content' => fake() -> paragraph(),
            'heard' => $heard,
            'echoes' => fake() -> numberBetween(0, $heard / 10),
            'claps' => fake() -> numberBetween(0, $heard / 2),
        ];
    }

    /**
     * Helper Method that uses the user count to calculate heard.
     *
     * Takes user_count as input and fakes a random number between 0 and user_count
     *
     * @param $user_count integer
     * @return PostFactory
     */
    public function withUserCount($user_count)
    {
        return $this
                -> state(fn () => ['heard' => fake()
                                            -> numberBetween(0, $user_count)
                ]);
    }
}
