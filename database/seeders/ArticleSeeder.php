<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use Carbon\Factory;
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
        $users = User::all();

        // タグ付きの記事を作成
        foreach ($users as $user) {
            Article::factory(2)
                ->has(
                    Tag::factory()
                        ->count(2)
                )
                ->hasAttached(
                    Comment::factory()->count(2),
                    ['user_id' => $users->random()->id]
                )
                ->for($user)
                ->create();
        }
    }
}