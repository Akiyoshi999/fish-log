<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * お気に入り処理
     *
     * @test
     */
    public function Favorite()
    {
        // 認証
        $user = User::where('name', 'ubuntu')->first();
        $this->actingAs($user);
        $this->assertAuthenticated();

        // いいね処理
        $article = Article::where('user_id', $user->id)->first();
        $this->put(route('articles.favorite', [
            'article' => $article
        ]));
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'article_id' => $article->id,
        ]);
    }

    /**
     * お気に入り解除
     *
     * @test
     */
    public function UnFavorite()
    {
        // 認証
        $user = User::where('name', 'ubuntu')->first();
        $this->actingAs($user);
        $this->assertAuthenticated();

        // いいね処理
        $article = Article::where('user_id', $user->id)->first();
        $this->put(route('articles.favorite', [
            'article' => $article
        ]));
        // いいねの確認
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'article_id' => $article->id,
        ]);

        // いいね解除
        $this->delete(route('articles.favorite', [
            'article' => $article
        ]));
        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'article_id' => $article->id,
        ]);
    }
}