<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * いいね機能が正常に動作していること
     *
     * @test
     */
    public function Like()
    {
        // 認証
        $user = User::where('name', 'ubuntu')->first();
        $this->actingAs($user);
        $this->assertAuthenticated();

        // いいね処理
        $article = Article::where('user_id', $user->id)->first();
        $this->put(route('articles.like', [
            'article' => $article
        ]));
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'article_id' => $article->id,
        ]);
    }

    /**
     * いいね解除
     *
     * @test
     */
    public function UnLike()
    {
        // 認証
        $user = User::where('name', 'ubuntu')->first();
        $this->actingAs($user);
        $this->assertAuthenticated();

        // いいね処理
        $article = Article::where('user_id', $user->id)->first();
        $this->put(route('articles.like', [
            'article' => $article
        ]));
        // いいねの確認
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'article_id' => $article->id,
        ]);

        // いいね解除
        $this->delete(route('articles.like', [
            'article' => $article
        ]));
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'article_id' => $article->id,
        ]);
    }
}