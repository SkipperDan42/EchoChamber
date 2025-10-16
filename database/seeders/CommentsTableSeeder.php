<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ////////////////////////////////////////// MANUAL SEEDING //////////////////////////////////////////

        // Create new Comment (for PostID = 1, UserID = 12) with Direct Assignment
        $post = Post::first();
        if ($post) {
            $heard = fake()
                        -> numberBetween(0, $post -> heard);
            $a = new Comment();
            $a -> user_id = 12;
            $a -> post_id = $post -> id;
            $a -> content = "Woop! Can't wait to hear all these opinions I agree with!";
            $a -> heard = $heard;
            $a -> claps = fake() -> numberBetween(0, $heard);
            $a -> save();
        }


        // Create new Comment (for Post title = 'Bloody Boats!'  &  User email = 'aj@infowars.com') with Create
        $post = Post::where('title', 'Bloody Boats!')
                    -> first();
        $user = User::where('email', 'aj@infowars.com')
                    -> first();
        if ($post && $user) {
            $heard = fake()
                    -> numberBetween(0, $post -> heard);
            $b = new Comment();
            $b -> create([  'user_id' => $user -> id,
                            'post_id' => $post -> id,
                            'content' => 'All these immigrants turning the boats gay!',
                            'heard' => $heard,
                            'claps' => fake() -> numberBetween(0, $heard),
                        ])
                        -> save();
        }


        ////////////////////////////////////////// FACTORY SEEDING //////////////////////////////////////////

        // Create comments with a factory
        Comment::factory()
                    -> count(998)
                    -> create();
    }
}
