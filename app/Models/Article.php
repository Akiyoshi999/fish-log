<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use HasFactory;

    // 可変項目
    protected $fillable = [
        'title',
        'date',
        'place',
        'weather',
        'tide',
        'temperature',
        'fish',
        'length',
        'comment',
        'file_name',
    ];

    /**
     * Usersテーブルとの紐付け
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * likesテーブルを中間としてUsersと紐付け
     *
     * @return BelongsToMany
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }


    /**
     * favoritesテーブルを中間としてUsersと紐付け
     *
     * @return BelongsToMany
     */
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    /**
     * article_tagテーブルを中間としてtagsテーブルと紐付け
     *
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'article_tag')->using(ArticleTag::class)->withTimestamps();
    }

    /**
     * user_article_commentテーブルを中間としてcommentsテーブルと紐付け
     *
     * @return BelongsToMany
     */
    public function comments(): BelongsToMany
    {
        return $this->belongsToMany(Comment::class, 'user_article_comment')
            ->using(UserArticleComment::class)->withPivot('user_id')->withTimestamps();
    }

    /**
     * いいね済みかの判定
     *
     * @param User|null $user
     * @return boolean
     */
    public function isLikedBy(?User $user): bool
    {
        return $user ?
            (bool)$this->likes->where('id', $user->id)->count()
            : false;
    }

    /**
     * お気に入り済みかの判定
     *
     * @param User|null $user
     * @return boolean
     */
    public function isFavoritedBy(?User $user): bool
    {
        return $user ?
            (bool)$this->favorites->where('id', $user->id)->count()
            : false;
    }

    /**
     * いいね数を算出
     *
     * @return int
     */
    public function getCountLikesAttribute(): int
    {
        return $this->likes->count();
    }

    /**
     * 記事のタグ表示
     *
     * @return object
     */
    public function articleTag(): object
    {
        return $this->tags->map(function ($tag): array {
            return ['text' => $tag->name];
        });
    }

    /**
     * 記事のコメント表示の制限
     *
     * @param string $comment
     * @return string
     */
    public function limitComment(string $comment): string
    {
        $limit = 32;
        if (mb_strlen($comment) > $limit) {
            return mb_substr($comment, 0, $limit) . "...";
        } else {
            return $comment;
        }
    }
}