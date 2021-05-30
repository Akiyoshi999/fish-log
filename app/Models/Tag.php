<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Article')->withTimestamps();
    }

    /**
     * 全てのタグを取得する
     *
     * @return object
     */
    public function AllTagNames(): object
    {
        return $this->all()->map(function ($tag): array {
            return ['text' => $tag->name];
        });
    }

    /**
     * タグに#をつける
     *
     * @return string
     */
    public function getHashtagAttribute(): string
    {
        return '#' . $this->name;
    }
}