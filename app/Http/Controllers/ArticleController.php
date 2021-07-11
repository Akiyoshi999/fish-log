<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }

    /**
     * 投稿記事を全て表示する
     *
     * @return View
     */
    public function index(): View
    {
        $articles = Article::all()->sortByDesc('created_at')
            ->load([
                'user', 'likes', 'favorites', 'tags',
            ]);
        return view('articles.index', ['articles' => $articles]);
    }

    /**
     * 記事作成画面の表示
     *
     * @return View
     */
    public function create(Tag $tags): View
    {
        $allTagNames = $tags->AllTagNames();
        return view('articles.create', [
            'allTagNames' => $allTagNames,
        ]);
    }

    /**
     * 釣果記録の登録処理
     *
     * @param ArticleRequest $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(ArticleRequest $request)
    {
        $user = $request->user();
        $input = $request->all();

        $input = $request->preprocessing($input);

        DB::beginTransaction();
        try {
            $article = $user->articles()->create($input);
            $request->tags->each(function ($tagName) use ($article) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $article->tags()->attach($tag);
            });
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            logger()->error($e, ['file' => __FUNCTION__, 'line' => __LINE__]);
            abort(500);
        }

        Session::flash('success_msg', '釣果情報を投稿しました');

        return redirect(route('top'));
    }

    /**
     * 記事更新画面の表示
     *
     * @param Article $article
     * @return View
     */
    public function edit(Article $article, Tag $tags): View
    {
        $tagNames = $article->articleTag();
        $allTagNames = $tags->AllTagNames();
        return view('articles.edit', [
            'article' => $article,
            'tagNames' => $tagNames,
            'allTagNames' => $allTagNames,
        ]);
    }

    /**
     * 記事更新処理
     *
     * @param ArticleRequest $request
     * @param Article $article
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $input = $request->all();

        $input = $request->preprocessing($input);

        DB::beginTransaction();
        try {
            // 記事の画像更新があり、且つ前画像がストレージにある場合削除
            // if (!empty($input['file_name'] && Storage::exists('public/' . $article->file_name))) {
            //     Storage::delete('public/' . $article->file_name);
            // }

            // 画像更新なしの場合、要素の削除
            // if (empty($input['file_name'])) {
            //     unset($input['file_name']);
            // }

            $article->fill($input)->save();
            $article->tags()->detach();
            $request->tags->each(function ($tagName) use ($article) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $article->tags()->attach($tag);
            });
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            logger()->error($e, ['file' => __FUNCTION__, 'line' => __LINE__]);
            abort(500);
        }

        Session::flash('success_msg', '釣果情報を更新しました');

        return redirect(route('top'));
    }

    /**
     * 記事削除処理
     *
     * @param Article $article
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Article $article)
    {
        DB::beginTransaction();
        try {
            // ストレージの画像削除処理
            if (Storage::exists('public/' . $article->file_name)) {
                Storage::delete('public/' . $article->file_name);
            }
            $article->delete();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            logger()->error($e, ['file' => __FUNCTION__, 'line' => __LINE__]);
            abort(500);
        }

        Session::flash('success_msg', '釣果情報を削除しました');

        return redirect(route('top'));
    }

    /**
     * 投稿記事の詳細画面の表示
     *
     * @param Article $article
     * @return View
     */
    public function show(Article $article): View
    {
        $article = $article->load([]);
        return view('articles.show', ['article' => $article]);
    }


    /**
     * いいね処理
     *
     * @param Request $request
     * @param Article $article
     * @return void
     */
    public function like(Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);
        $article->likes()->attach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }

    /**
     * いいね解除
     *
     * @param Request $request
     * @param Article $article
     * @return array
     */
    public function unlike(Request $request, Article $article): array
    {
        $article->likes()->detach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }

    /**
     * お気に入り登録
     *
     * @param Request $request
     * @param Article $article
     * @return array
     */
    public function favorite(Request $request, Article $article): array
    {
        $article->favorites()->detach($request->user()->id);
        $article->favorites()->attach($request->user()->id);

        return [
            'id' => $article->id,
        ];
    }

    /**
     * お気に入り解除
     *
     * @param Request $request
     * @param Article $article
     * @return array
     */
    public function unfavorite(Request $request, Article $article): array
    {
        $article->favorites()->detach($request->user()->id);

        return [
            'id' => $article->id,
        ];
    }

    /**
     * 記事検索
     *
     * @param Request $request
     * @return View
     */
    public function search(Request $request): View
    {
        $word = $request->all()['word'];
        $articles = Article::where('comment', 'like', "%$word%")->get()->sortByDesc('created_at')
            ->load([
                'user', 'likes'
            ]);

        return view('articles.index', ['articles' => $articles]);
    }
}