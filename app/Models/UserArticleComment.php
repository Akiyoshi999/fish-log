<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserArticleComment extends Pivot
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}