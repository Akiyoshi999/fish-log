<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),


    'weather' => ["晴れ", "曇り", "雨", "雪"],

    'place' => [
        "北海道", "青森", "岩手", "秋田", "山形", "宮城",
        "福島", "新潟", "栃木", "茨城", "千葉", "東京",
        "神奈川", "埼玉", "群馬", "富山", "石川", "長野",
        "山梨", "静岡", "福井", "岐阜", "愛知", "滋賀", "三重",
        "京都", "兵庫", "大阪", "奈良", "和歌山", "鳥取",
        "岡山", "島根", "広島", "広島", "山口", "香川",
        "徳島", "愛媛", "高知", "福岡", "大分", "宮崎",
        "鹿児島", "熊本", "佐賀", "長崎", "沖縄"
    ],

    'tide' => [
        "大潮", "中潮", "小潮",
        "長潮", "若潮"
    ],

    'fish' => [
        "シーバス", "タイ", "アジ", "太刀魚", "メバル", "カサゴ", "ブリ", "イカ",
        "ヒラメ", "タコ", "カマス", "カレイ", "サワラ", "カンパチ", "イサキ",
        "サヨリ", "イサキ", "ダツ", "シイラ", "マグロ", "その他"
    ]

];