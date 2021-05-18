<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Userの数＊２の記事作成
        $users = User::all();
        foreach ($users as $user) {
            Article::factory()
                ->count(2)
                ->for($user)
                ->create();
        }
    }
}