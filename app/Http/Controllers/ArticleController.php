<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        // ダミーデータ
        $articles = [
            (object)[
                'id' => 1,
                'user' => (object)[
                    'id' => 1,
                    'name' => 'テlト太郎',
                ],
                'date' => 2020 / 01 / 01,
                'place' => '東京都',
                'weather' => '晴れ',
                'tide' => '大潮',
                'temperature' => 18.2,
                'fish' => 'シーバス',
                'length' => 72,
                'comment' => 'やった',
                'created_at' => now(),
            ],
            (object)[
                'id' => 2,
                'user' => (object)[
                    'id' => 2,
                    'name' => 'テト太郎',
                ],
                'date' => 2020 / 02 / 01,
                'place' => '山形',
                'weather' => '曇り',
                'tide' => '小潮',
                'temperature' => 10.2,
                'fish' => '黒鯛',
                'length' => 42,
                'comment' => 'まじか',
                'created_at' => now(),
            ],
        ];
        return view('articles.index', ['articles' => $articles]);
    }
}