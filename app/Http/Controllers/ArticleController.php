<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ArticleController extends Controller
{
    // public function __construct()
    // {
    //     $this->authorizeResource(Article::class, 'article');
    // }

    /**
     * 投稿記事を全て表示する
     *
     * @return View
     */
    public function index(): View
    {
        $articles = Article::all()->sortByDesc('created_at');

        return view('articles.index', ['articles' => $articles]);
    }


    /**
     * 記事作成画面の表示
     *
     * @return View
     */
    public function create(): View
    {
        return view('articles.create');
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

        DB::beginTransaction();
        try {
            $user->articles()->create($input);
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
    public function edit(Article $article): View
    {
        return view('articles.edit', [
            'article' => $article,
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

        DB::beginTransaction();
        try {
            $article->fill($input)->save();
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
     * @return void
     */
    public function unlike(Request $request, Article $article)
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
     * @return void
     */
    public function favorite(Request $request, Article $article)
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
     * @return void
     */
    public function unfavorite(Request $request, Article $article)
    {
        $article->favorites()->detach($request->user()->id);

        return [
            'id' => $article->id,
        ];
    }
}