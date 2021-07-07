<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use League\CommonMark\Inline\Element\Strong;

class UserController extends Controller
{

    /**
     * ユーザーページ表示
     *
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        $user = $user->load([
            'articles.user', 'articles.likes',
        ]);
        $articles = $user->articles->sortByDesc('created_at');
        return view('users.show', [
            'user' => $user,
            'articles' => $articles,
        ]);
    }

    /**
     * ユーザー情報更新
     *
     * @param Request $request
     * @param User $user
     * @return View
     */
    public function update(Request $request, User $user): View
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            $user->fill([
                'name' => $input['name'],
                'icon' => $input['icon'],
            ])->save();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            logger()->error($e, ['file' => __FUNCTION__, 'line' => __LINE__]);
            abort(500);
        }
        $articles = $user->articles->load([
            'user', 'likes',
        ])->sortByDesc('created_at');
        return view('users.show', [
            'user' => $user,
            'articles' => $articles,
        ]);
    }


    /**
     * お気に入りした記事の表示
     *
     * @param User $user
     * @return View
     */
    public function favorites(User $user): View
    {
        $user = $user->load(['favorites.user', 'favorites.likes']);
        $articles = $user->favorites->sortByDesc('created_at');
        return view('users.favorites', [
            'user' => $user,
            'articles' => $articles,
        ]);
    }

    /**
     * フォローユーザーの表示
     *
     * @param User $user
     * @return View
     */
    public function followings(User $user): View
    {
        $user = $user->load(['followings.followers']);
        $followings = $user->followings->sortByDesc('created_at');
        return view('users.followings', [
            'user' => $user,
            'followings' => $followings
        ]);
    }

    /**
     * フォロワー表示
     *
     * @param User $user
     * @return View
     */
    public function followers(User $user): View
    {
        $followers = $user->followers
            ->load(['followers',])->sortByDesc('created_at');
        return view('users.followers', [
            'user' => $user,
            'followers' => $followers
        ]);
    }

    /**
     * フォロー処理
     *
     * @param Request $request
     * @param string $name
     * @return array
     */
    public function follow(Request $request, string $name): array
    {
        $user = User::where('name', $name)->first();
        if ($user->id === $request->user()->id) {
            return abort('404', 'Cannot follow yourself');
        }

        $request->user()->followings()->detach($user);
        $request->user()->followings()->attach($user);

        return ['name' => $name];
    }

    /**
     * フォロー解除
     *
     * @param Request $request
     * @param string $name
     * @return array
     */
    public function unfollow(Request $request, string $name): array
    {
        $user = User::where('name', $name)->first();
        if ($user->id === $request->user()->id) {
            return abort('404', 'Cannot follow yourself');
        }

        $request->user()->followings()->detach($user);

        return ['name' => $name];
    }
}