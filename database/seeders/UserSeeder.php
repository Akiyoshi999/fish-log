<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            // ->has(Article::factory()->count(2))
            // ->hasArticles(2)
            // ->count(10)
            ->create();
    }
}