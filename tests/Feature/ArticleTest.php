<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArticleRegister extends TestCase
{
    use RefreshDatabase;
    // $response->dumpSession();

    /**
     * 記事一覧ページの表示(ゲスト)
     *
     * @test
     */
    public function ViewArticleGuest()
    {
        $response = $this->get(route('top'));
        $response->assertOk()->assertViewIs('articles.index');
        $this->assertGuest();
    }

    /**
     * 記事一覧ページの表示(認証)
     *
     * @test
     */
    public function ViewArticleAuth()
    {
        $user = User::find(1);
        $this->actingAs($user);
        $response = $this->get(route('top'));
        $response->assertOk()->assertViewIs('articles.index');
        $this->assertAuthenticated();
    }

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
     * 記事が正常に投稿できるか
     *
     * @test
     */
    public function CreateArticleImage()
    {
        Storage::fake('public/uploads');
        $file = UploadedFile::fake()->image(uniqid() . 'fish.jpg');

        $this->actingAs(User::find(1));
        $response = $this->post(route('articles.store'), [
            'title' => '画像アップロードテスト',
            'tags' => '[{"text":"東京湾","tiClasses":["ti-valid"]}]',
            'date' => '2021-05-31',
            'place' => '新潟',
            'weather' => '晴れ',
            'tide' => '中潮',
            'temperature' => '27',
            'fish' => 'シーバス',
            'length' => '45',
            'comment' => 'やったぜ',
            'image' => $file,
        ]);
        $response->assertStatus(302)
            ->assertRedirect(route('top'));

        $test = Article::where('title', '画像アップロードテスト')->first();
        $this->assertDatabaseHas('articles', [
            'title' => '画像アップロードテスト',
        ]);

        // 対象の画像が保存されているかの確認
        $name = $file->name;
        $this->assertTrue(!empty(preg_grep("/$name/", Storage::allFiles('public/uploads'))));

        $target = Article::where("file_name", "LIKE", "%$name%")->first();
        $this->assertTrue(!empty($target));
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
        $response->assertStatus(302)
            ->assertRedirect(route('top'));
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

    /**
     * 記事削除テスト
     * ストレージの画像が削除されていることを確認
     *
     * @test
     */
    public function DeleteArticleImage()
    {
        Storage::fake('public/uploads');

        $user = User::where('name', 'ubuntu')->first();
        $this->actingAs($user);
        $this->assertAuthenticated();

        $article = Article::where('user_id', $user->id)->orderBy('id', 'desc')->first();
        $file_name = str_replace('uploads/', '', $article->file_name);

        // 記事削除前に画像がストレージに存在していることを確認
        $this->assertTrue(!empty(preg_grep("/$file_name/", Storage::allFiles('public/uploads'))));
        $response = $this->delete(route('articles.destroy', [
            'article' => $article,
        ]));
        $response->assertStatus(302)->assertRedirect(route('top'));
        $this->assertDeleted($article);

        // 記事削除後に画像がストレージから削除されていることを確認
        $this->assertTrue(empty(preg_grep("/$file_name/", Storage::allFiles('public/uploads'))));
    }

    /**
     * 記事検索(ゲスト)
     *
     * @test
     */
    public function SearchGuest()
    {
        $article = Article::find(1);
        $response = $this->get(route('search', [
            'word' => mb_substr($article->comment, 0, 3)
        ]));

        $this->assertGuest();
        $response->assertViewIs('articles.index')
            ->assertSeeText(mb_substr($article->comment, 0, 3));
    }

    /**
     * 記事検索(認証)
     *
     * @test
     */
    public function SearchAuth()
    {
        $this->actingAs(User::find(1));
        $article = Article::find(1);
        $response = $this->get(route('search', [
            'word' => mb_substr($article->comment, 0, 3)
        ]));

        $this->assertAuthenticated();
        $response->assertViewIs('articles.index')
            ->assertSeeText(mb_substr($article->comment, 0, 3));
    }
}