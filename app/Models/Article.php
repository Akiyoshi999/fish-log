<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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