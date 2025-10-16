<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::all()
                    -> random();
        $post = Post::all()
                    -> random();
        $heard = fake()
                    -> numberBetween(0, $post -> heard);

        return [
            'user_id' => $user -> id,
            'post_id' => $post -> id,
            'content' => fake() -> sentence(),
            'heard' => $heard,
            'claps' => fake() -> numberBetween(0, $heard),
        ];
    }
}
