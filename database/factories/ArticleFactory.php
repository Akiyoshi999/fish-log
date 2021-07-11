<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $locale = [
            "北海道", "青森", "岩手", "秋田", "山形", "宮城",
            "福島", "新潟", "栃木", "茨城", "千葉", "東京",
            "神奈川", "埼玉", "群馬", "富山", "石川", "長野",
            "山梨", "静岡", "福井", "岐阜", "愛知", "滋賀", "三重",
            "京都", "兵庫", "大阪", "奈良", "和歌山", "鳥取",
            "岡山", "島根", "広島", "広島", "山口", "香川",
            "徳島", "愛媛", "高知", "福岡", "大分", "宮崎",
            "鹿児島", "熊本", "佐賀", "長崎", "沖縄"
        ];

        $weather = [
            "晴れ", "曇り", "雨", "雪"
        ];

        $tide = [
            "大潮", "中潮", "小潮",
            "長潮", "若潮",
        ];

        $fish = [
            "シーバス", "タイ", "アジ", "太刀魚", "メバル", "カサゴ", "ブリ", "イカ",
            "ヒラメ", "タコ", "カマス", "カレイ", "サワラ", "カンパチ", "イサキ",
            "サヨリ", "イサキ", "ダツ", "シイラ", "マグロ",
        ];

        // #27 画像検索機能無効
        // $file = UploadedFile::fake()->image('AAA.jpg');
        // $file_path = Storage::putFile('public/uploads', $file);
        // $file_path = str_replace('public/', '', $file_path);

        return [
            // テストデータを作成
            'title' => $this->faker->text($maxNbChars = 20),
            // 'tag' => json_encode([
            //     [
            //         "text" => $this->faker->word(),
            //         "tiClasses" => ["ti-valid"]
            //     ],
            //     [
            //         "text" => $this->faker->word(),
            //         "tiClasses" => ["ti-valid"]
            //     ]
            // ]),
            'date' => $this->faker->dateTimeThisDecade($timezone = "Asia/Tokyo"),
            'place' => $this->faker->randomElement($locale),
            'weather' => $this->faker->randomElement($weather),
            'tide' => $this->faker->randomElement($tide),
            'temperature' => $this->faker->numberBetween($min = -10, $max = 50),
            'fish' => $this->faker->randomElement($fish),
            'length' => $this->faker->numberBetween($min = 0, $max = 200),
            'comment' => $this->faker->realText($maxNbChars = 50),
            // #27 画像検索機能無効
            // 'file_name' => $file_path,
        ];
    }
}