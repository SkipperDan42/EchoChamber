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
     * This will return a faked post with some restrictions:
     * - Post is from a random User (FK: user_id)
     * - Post can only be 'heard' by at most the number of users (set in Seeder, otherwise max=1)
     * - Post can only be echoed by at most a tenth of users (to reduce entries in DB)
     * - Post can only be clapped by at most half of users
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Fake heard manually as 100
        // Should be overwritten using withUserCount Factory Helper Method
        $heard = 100;

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
                -> state(function (array $attributes) use ($user_count) {
                    $heard = fake()->numberBetween(0, $user_count);
                    return [
                        'heard' => $heard,
                        'echoes' => fake()->numberBetween(0, $heard / 10),
                        'claps' => fake()->numberBetween(0, $heard / 2),
                    ];
        });
    }

    /**
     * Helper Method that takes the original post and copies it.
     *
     * Takes post as input and copies the title and content
     * Sets echoes as 0 to avoid having to echo echoes
     * Sets the post id as echoed
     *
     * @param $post PostFactory
     * @return PostFactory
     */
    public function withEcho($post)
    {
        return $this
            -> state(function (array $attributes) use ($post) {
                return [
                    'title' => $post -> title,
                    'content' => $post -> content,
                    'echoes' => 0,
                    'echoed' => $post -> id,
                ];
            });
    }
}
