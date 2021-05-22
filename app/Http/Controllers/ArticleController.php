<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ArticleController extends Controller
{
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
     * @return void
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

        return redirect(route('top'));
    }

    /**
     * 記事更新画面の表示
     *
     * @return View
     */
    public function edit(Article $article): View
    {
        return view('articles.edit', [
            'article' => $article,
        ]);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $user = $request->user();
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
}