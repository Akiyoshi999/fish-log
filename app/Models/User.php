<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'icon'
    ];

    protected $attributes = [
        "icon" => "fas fa-user-circle"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * articleテーブルの紐付け
     *
     * @return HasMany
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
        // return $this->hasMany('App\Models\Article');
    }

    /**
     * favorites → articleへの紐付け
     *
     * @return BelongsToMany
     */
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\Article', 'favorites')
            ->withTimestamps();
    }

    /**
     * followsテーブルの紐付け
     *
     * @return BelongsToMany
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\User', 'follows', 'followee_id', 'follower_id')
            ->withTimestamps();
    }

    /**
     * フォロワー→フォロー対象へのリレーション
     *
     * @return BelongsToMany
     */
    public function followings(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\User', 'follows', 'follower_id', 'followee_id')
            ->withTimestamps();
    }

    /**
     * フォロー判定
     *
     * @param User|null $user
     * @return boolean
     */
    public function isFollowedBy(?User $user): bool
    {
        return $user
            ? (bool)$this->followers->where('id', $user->id)->count()
            : false;
    }

    /**
     * フォロワー数のアクセサ
     *
     * @return integer
     */
    public function getCountFollowersAttribute(): int
    {
        return $this->followers->count();
    }

    /**
     * フォロー数のアクセサ
     *
     * @return integer
     */
    public function getCountFollowingsAttribute(): int
    {
        return $this->followings->count();
    }
}