<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create new admin User with Direct Assignment (bypasses $fillable)
        $a = new User();
        $a -> first_name = "Dan";
        $a -> last_name = "North";
        $a -> email = "2039924@echochamber.com";
        $a -> administrator_flag = true;
        $a -> password = bcrypt("SYSarchitect!");
        $a -> save();


        // Create new admin User with forceFill (bypasses $fillable)
        $b = new User();
        $b -> forceFill(['email' => 'admin@echochamber.com',
                         'administrator_flag' => true,
                         'password' => bcrypt('admin')
                        ])
                        -> save();


        // Create new regular User with Direct Assignment (bypasses $fillable)
        $c = new User();
        $c -> first_name = "Nigel";
        $c -> last_name = "Farage";
        $c -> email = "2pintNigel@ukip.co.uk";
        $c -> administrator_flag = false;
        $c -> password = bcrypt("password");
        $c -> save();


        // Create new regular User with forceFill (bypasses $fillable)
        $d = new User();
        $d -> forceFill(['first_name' => 'alex',
                         'last_name' => 'jones',
                         'email' => 'aj@infowars.com',
                         'administrator_flag' => false,
                         'password' => bcrypt('turnTHEfrogsGAY')
                        ])
                        -> save();

        // Create non-admin users with a factory (98 for total 100 non-admin users)
        User::factory()
                -> count(98)
                -> create();

        // Create admin users with a factory (3 for total 5 admin users)
        User::factory()
                ->count(3)
                ->state(fn () => [  'email' => fake() -> userName() . '@echochamber.com',
                                    'administrator_flag' => true])
                ->create();
    }
}
