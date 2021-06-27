<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use PhpParser\Node\Expr\Cast\Bool_;
use SebastianBergmann\Environment\Console;
use Symfony\Component\Console\Input\Input;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Comment $comment)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Article $article, Comment $comment)
    {
    }

    /**
     * 記事コメント投稿
     *
     * @param CommentRequest $request
     * @param Comment $comment
     * @param Article $article
     * @return RedirectResponse
     */
    public function store(CommentRequest $request, Comment $comment, Article $article): RedirectResponse
    {
        $input = $request->all();

        DB::beginTransaction();
        try {
            $comment = $comment->create($input);
            $article->comments()->attach(
                $comment->id,
                ['user_id' => $request->user()->id]
            );
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            logger()->error($e, ['file' => __FUNCTION__, 'line' => __LINE__]);
            abort(500);
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 記事のコメント更新
     *
     * @param Request $request
     * @param Article $article
     * @param Comment $comment
     * @return array
     */
    public function update(Request $request, Article $article, Comment $comment): array
    {
        $input = $request->all();

        DB::beginTransaction();
        try {
            $comment->fill($input)->save();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            logger()->error($e, ['file' => __FUNCTION__, 'line' => __LINE__]);
            abort(500);
        }
        return [
            'id' =>  $article->id,
            'content' => $comment->content
        ];
    }

    /**
     * 記事コメント削除処理
     *
     * @param Request $request
     * @param Article $article
     * @param Comment $comment
     * @return boolean
     */
    public function destroy(Request $request, Article $article, Comment $comment): bool
    {
        $input = $request->all();
        print_r($input);

        DB::beginTransaction();
        try {
            $comment->delete();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            logger()->error($e, ['file' => __FUNCTION__, 'line' => __LINE__]);
            abort(500);
        }
        return true;
    }
}