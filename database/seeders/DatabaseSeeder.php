<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database by calling the seeders for each model.
     *
     * Models must be called in turn due to their Foreign Keys (Users->Posts->Comments)
     */
    public function run(): void
    {
        $this -> call([ UsersTableSeeder::class,
            PostsTableSeeder::class,
            CommentsTableSeeder::class
        ]);
    }
}
