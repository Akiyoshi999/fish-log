<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleCommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 記事のコメント登録テスト
     *
     * @test
     */
    public function CommentCreate()
    {
        // 認証
        $user = User::where('name', 'ubuntu')->first();
        $this->actingAs($user);
        $this->assertAuthenticated();

        // コメント登録
        $comment = 'コメント登録';
        $article = Article::where('user_id', $user->id)->first();
        $this->post(route('articles.comment.store', [
            'article' => $article,
            'content' => $comment
        ]));

        // コメント登録がDBにされていることを確認
        $this->assertDatabaseHas('comments', [
            'content' => $comment
        ]);
    }


    /**
     * 記事のコメント登録テスト(ゲスト)
     *
     * @test
     */
    public function CommentCreateNoLogin()
    {
        // 認証
        $user = User::where('name', 'ubuntu')->first();
        $this->assertGuest();

        // コメント登録
        $comment = 'コメント登録';
        $article = Article::where('user_id', $user->id)->first();
        $this->post(route('articles.comment.store', [
            'article' => $article,
            'content' => $comment
        ]));

        // コメント登録がDBにされていることを確認
        $this->assertDatabaseMissing('comments', [
            'content' => $comment
        ]);
    }

    /**
     * 記事更新テスト
     *
     * @test
     */
    public function CommentUpdate()
    {
        // ログイン処理
        $user = User::where('name', 'ubuntu')->first();
        $this->actingAs($user);
        $this->assertAuthenticated();

        // 記事取得
        $article = Article::where('user_id', $user->id)->first();
        $article_comment = $article->comments->first();

        $comment = 'コメント更新テスト';
        $this->assertDatabaseMissing('comments', [
            'content' => $comment,
        ]);

        // 記事更新
        $response = $this->put(route(
            'articles.comment.update',
            [
                'article' => $article,
                'comment' => $article_comment,
                'content' => $comment
            ],
        ));
        $this->assertDatabaseHas('comments', [
            'content' => $comment,
        ]);
    }
}