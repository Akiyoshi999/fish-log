<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

use function GuzzleHttp\Promise\each;

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
            Article::factory(2)->has(
                Tag::factory()->count(2)
            )->for($user)->create();
        }
    }
}