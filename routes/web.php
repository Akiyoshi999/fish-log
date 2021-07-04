<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();
Route::get('/', [ArticleController::class, 'index'])->name('top');

Route::resource('/articles', ArticleController::class)
    ->except(['index', 'show'])->middleware('auth');

Route::resource('/articles', ArticleController::class)->only(['show']);

Route::prefix('articles/{article}')->name('articles.')->group(function () {
    Route::put('/like', [ArticleController::class, 'like'])->name('like')->middleware('auth');
    Route::delete('/like', [ArticleController::class, 'unlike'])->name('unlike')->middleware('auth');
    Route::put('/favorite', [ArticleController::class, 'favorite'])->name('favorite')->middleware('auth');
    Route::delete('/favorite', [ArticleController::class, 'unfavorite'])->name('unfavorite')->middleware('auth');
    Route::resource('/comment', CommentController::class)
        ->except(['show', 'edit', 'index', 'create']);
});

Route::get('/tags/{name}', [TagController::class, 'show'])->name('tags.show');

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/{user}', [UserController::class, 'show'])->name('show');
    Route::put('/{user}/update', [UserController::class, 'update'])->name('update');
    Route::get('/{user}/favorites', [UserController::class, 'favorites'])->name('favorites');
    Route::get('/{user}/followings', [UserController::class, 'followings'])->name('followings');
    Route::get('/{user}/followers', [UserController::class, 'followers'])->name('followers');
    Route::middleware('auth')->group(function () {
        Route::put('/{name}/follow', [UserController::class, 'follow'])->name('follow');
        Route::delete('/{name}/follow', [UserController::class, 'unfollow'])->name('unfollow');
    });
});