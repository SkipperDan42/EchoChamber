<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ////////////////////////////////////////// MANUAL SEEDING //////////////////////////////////////////

        // Create new Post (for UserID = 1) with Direct Assignment
        $user = User::first();
        if ($user) {
            $a = new Post();
            $a -> user_id = $user -> id;
            $a -> title = "EchoChamber is LIVE!";
            $a -> content = "Just testing the system guys! EchoChamber is now ready to use.";
            $a -> heard = 100;
            $a -> echoes = 5;
            $a -> claps = 25;
            $a -> save();
        }

        // Create new Post (for User email = '2pintNigel@ukip.co.uk') with Create
        $user = User::where('email', '2pintNigel@ukip.co.uk')
            -> first();
        if ($user) {
            $b = new Post();
            $b -> create(['user_id' => $user -> id,
                'title' => 'Bloody Boats!',
                'content' => 'These bloody boats in OUR CHANNEL. Arrgghh, racist rhetoric. Nonsense point. BRITAIN!',
                'heard' => 98,
                'echoes' => 9,
                'claps' => 91,
            ])
                -> save();
        }

        // Create new Post (for random users) with Direct Assignment
        $users = User::all();
        if ($users) {
            $c = new Post();
            $c -> user_id = $users -> random() -> id;
            $c -> title = "I've said it before!";
            $c -> content = "And I'll say it again. Love this website. I only ever hear my own heard reflected. Epic.";
            $c -> heard = 10;
            $c -> echoes = 1;
            $c -> claps = 9;
            $c -> save();
        }

        // Create new Post (for random users) with Create
        $users = User::all();
        if ($users) {
            $d = new Post();
            $d -> create(['user_id' => $users -> random() -> id,
                'title' => 'Stupid LIBS!',
                'content' => 'Got em! Never see em on-line anymore! Probly cryin, snowflakes. LOL',
                'heard' => 57,
                'echoes' => 17,
                'claps' => 52,
            ])
                -> save();
        }


        ////////////////////////////////////////// FACTORY SEEDING //////////////////////////////////////////

        // Get user ids and count and pass to a Factory Helper Method to reduce DB queries
        $users = User::all()->pluck('id');
        $user_count = $users->count();

        // Create original posts with a factory (each user making approximately 3 posts)
        // Factory uses withUserCount Helper Method
        Post::factory()
            -> withUserCount($user_count)
            -> count($user_count * 3)
            -> create();

        // Create echoes of posts that have been echoed (i.e. reposted)
        // Factory uses withUserCount Helper Method
        // Factory uses withEcho Helper Method
        // NOTE this could be a nested loop for re-re-posted, but for simplicity no dummy echoes are echoed
        $posts = Post::where('echoes' ,'>', 0)
                -> get();
        foreach ($posts as $post) {
            Post::factory()
                -> withUserCount($user_count)
                -> withEcho($post)
                -> count($post -> echoes)
                -> create();
        }

        // Create claps on posts that have been clapped (i.e. liked)
        // NOTE this uses the claps relationship to fill the post_claps pivot table
        $posts = Post::where('claps' ,'>', 0)
                -> get();
        foreach ($posts as $post) {
            // Take random selection of users for each clap, excluding the post owner
            $clappers = $users
                        -> reject(fn($id) => $id === $post->user_id)
                        -> shuffle()
                        -> take($post->claps);

            // Attach claps to pivot without removing previous ones
            $post->claps()->syncWithoutDetaching($clappers);
        }
    }
}
