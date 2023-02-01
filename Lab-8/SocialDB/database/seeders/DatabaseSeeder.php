<?php

namespace Database\Seeders;

use App\DBModels\FriendRequest;
use App\DBModels\Post;
use App\DBModels\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(5)->create(['gender' => rand(0, 1), 'date_of_birth' => rand(), 'last_visit' => rand()]);
        User::factory(5)->create(['gender' => rand(0, 1), 'date_of_birth' => rand(), 'last_visit' => rand()]);
        User::factory(5)->create(['gender' => rand(0, 1), 'date_of_birth' => rand(), 'last_visit' => rand()]);
        User::factory(5)->create(['gender' => rand(0, 1), 'date_of_birth' => rand(), 'last_visit' => rand()]);
        Post::factory(5)->create(['user_id' => rand(1, 20)]);
        Post::factory(5)->create(['user_id' => rand(1, 20)]);
        Post::factory(5)->create(['user_id' => rand(1, 20)]);
        Post::factory(5)->create(['user_id' => rand(1, 20)]);

    }
}
