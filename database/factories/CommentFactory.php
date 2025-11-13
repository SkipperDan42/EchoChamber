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
     *  This will return a comment with some restrictions:
     *  - Comment is from a random User (FK: user_id)
     *  - Comment is on a random Post (FK: post_id)
     *  - Comment can only be 'heard' by at most the number of users who heard the post
     *  - Comment can only be clapped by at most the number of users who heard the comment
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get a random users by sorting table randomly and taking first ID
        $user_id = User::query() -> inRandomOrder() -> value('id');

        // Get a random post by sorting table randomly and taking first ID
        $post_id = Post::query() -> inRandomOrder() -> value('id');

        // Get post from post_id and generate comment heard value by using heard value of post
        $post = Post::query() -> find($post_id);
        $heard = fake()
                    -> numberBetween(0, $post -> heard);

        return [
            'user_id' => $user_id,
            'post_id' => $post_id,
            'content' => fake() -> sentence(),
            'heard' => $heard,
            'claps' => fake() -> numberBetween(0, $heard),
        ];
    }
}
