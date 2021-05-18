<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
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
        User::factory()
            ->state([
                'name' => 'ubuntu',
                'email' => 'ubuntu@test.com',
            ])
            ->create();
        User::factory(2)->create();

        $users = User::all();

        foreach ($users as $user) {
            Article::factory()
                ->count(2)
                ->for($user)
                ->create();
        }
    }
}