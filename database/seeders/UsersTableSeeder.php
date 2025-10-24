<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ////////////////////////////////////////// MANUAL SEEDING //////////////////////////////////////////

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


        ////////////////////////////////////////// FACTORY SEEDING //////////////////////////////////////////

        // Generate default passwords outside of factory to speed-up seeding
        // (previously took 40s to create User table)
        $default_fake_password = bcrypt( fake() -> password() );
        $default_admin_password = bcrypt( "SuperStr0ng4dm1nP4ss" );

        // Create non-admin users with a factory (98 for total 100 non-admin users)
        // Password is passed from outside Factory
        User::factory()
                -> count(98)
                -> state(fn () => ['password' => $default_fake_password])
                -> create();

        // Create admin users with a factory (3 for total 5 admin users)
        // Password is passed from outside Factory
        User::factory()
                -> count(3)
                -> state(fn () => [  'email' => fake() -> userName() . '@echochamber.com',
                                     'administrator_flag' => true,
                                     'password' => $default_admin_password])
                -> create();
    }
}
