<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create new Post (for UserID = 1) with Direct Assignment
        $user = User::first();
        if ($user) {
            $a = new Post();
            $a -> user_id = $user -> id;
            $a -> title = "EchoChamber is LIVE!";
            $a -> content = "Just testing the system guys! EchoChamber is now ready to use.";
            $a -> views = 1000;
            $a -> echoes = 5;
            $a -> save();
        }


        // Create new Post (for User email = '2pintNigel@ukip.co.uk') with Create
        $user = User::where('email', '2pintNigel@ukip.co.uk') -> first();
        if ($user) {
            $b = new Post();
            $b -> create(['user_id' => $user->id,
                          'title' => 'Bloody Boats!',
                          'content' => 'These bloody boats in OUR CHANNEL. Arrgghh, racist rhetoric. Nonsense point. BRITAIN!'
                        ]) -> save();
        }


        // Create new Post (for random user) with Direct Assignment
        $users = User::all();
        if ($users) {
            $c = new Post();
            $c -> user_id = $users -> random() -> id;
            $c -> title = "I've said it before!";
            $c -> content = "And I'll say it again. Love this website. I only ever hear my own views reflected. Epic.";
            $a -> views = 10;
            $a -> echoes = 10;
            $c -> save();
        }


        // Create new Post (for random user) with Create
        $users = User::all();
        if ($users) {
            $d = new Post();
            $d -> create(['user_id' => $users -> random() -> id,
                          'title' => 'Stupid LIBS!',
                          'content' => 'Got em! Never see em on-line anymore! Probly cryin, snowflakes. LOL'
                        ]) -> save();
        }
    }
}
