<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleRegister extends TestCase
{
    use RefreshDatabase;
    // $response->dumpSession();

    /**
     * ログイン中に記事作成のページが開けるかどうか
     *
     * @test
     */
    public function CreateView()
    {
        $this->actingAs(User::find(1));
        $response = $this->get(route('articles.create'));
        $response->assertStatus(200)
            ->assertViewIs('articles.create');
        $this->assertAuthenticated();
    }

    /**
     * 記事が正常に投稿できるか
     *
     * @test
     */
    public function CreateArticle()
    {
        $this->actingAs(User::find(1));
        $response = $this->post(route('articles.store'), [
            'title' => '東京湾奥で１発ドカンと',
            'tags' => '[{"text":"東京湾","tiClasses":["ti-valid"]}]',
            'date' => '2021-05-31',
            'place' => '新潟',
            'weather' => '晴れ',
            'tide' => '中潮',
            'temperature' => '27',
            'fish' => 'シーバス',
            'length' => '45',
            'comment' => 'やったぜ',
        ]);
        $response->assertStatus(302)
            ->assertRedirect(route('top'));
        $this->assertDatabaseHas('articles', [
            'title' => '東京湾奥で１発ドカンと',
        ]);
    }

    /**
     * 記事が正常に更新されること
     *
     * @test
     */
    public function UpdateArticle()
    {
        // ログイン処理
        $user = User::where('name', 'ubuntu')->first();
        $this->actingAs($user);
        $this->assertAuthenticated();
        //記事編集画面
        $article = Article::where('user_id', $user->id)->first();
        $response =  $this->get(route('articles.edit', ['article' => $article]));;
        $response->assertViewIs('articles.edit');
        // 記事更新
        $response = $this->put(route('articles.update', [
            'article' => $article,
            'title' => '駿河湾でやりました',
            'tags' => '[{"text":"駿河湾","tiClasses":["ti-valid"]}]',
            'date' => '2021-05-31',
            'place' => '新潟',
            'weather' => '晴れ',
            'tide' => '中潮',
            'temperature' => '27',
            'fish' => 'シーバス',
            'length' => '45',
            'comment' => '更新テスト',
        ]));
        $response->assertStatus(302)->assertRedirect(route('top'));
        $this->assertDatabaseHas('articles', [
            'title' => '駿河湾でやりました',
        ]);

        $this->assertDatabaseHas('tags', [
            'name' => '駿河湾',
        ]);
    }


    /**
     * 記事削除テスト
     *
     * @test
     */
    public function DeleteArticle()
    {
        $user = User::where('name', 'ubuntu')->first();
        $this->actingAs($user);
        $this->assertAuthenticated();

        $article = Article::where('user_id', $user->id)->first();
        $response = $this->delete(route('articles.destroy', [
            'article' => $article,
        ]));

        $response->assertStatus(302)->assertRedirect(route('top'));
        $this->assertDeleted($article);
    }
}