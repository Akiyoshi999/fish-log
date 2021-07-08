#

## 使用コマンド

### 作成系

artisan make:test UserRegisterTest

#### database

php artisan make:seeder UserSeeder
php artisan make:seeder ArticleSeeder
php artisan mek:factory ArticleFactory --model=Article
php artisan migrate:fresh --seed --env=testing

### 起動コマンド

npm run watch

### インストール系

composer require laravel/ui
php artisan ui bootstrap
php artisan ui vue --auth
composer require intervention/image
npm i --save material-design-icons-iconfont @mdi/font vuetify

### キャッシャクリアコマンド

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

### DB 系

php artisan migrate
php artisan make:migration create_articles_table --create=articles
php artisan

## 頑張ったこと

1. レンダリングが一部のみ必要な箇所は、Vue を使用したこと
1. CircleCI を利用して、CI/CD の環境を構築し機能を追加したらテストも書く様にしたこと
1. ファットコントローラーにならないよう気をつけたこと
1. N+1 問題を意識したこと
    - [参照](https://beyondco.de/docs/laravel-query-detector/installation)

## 苦戦したこと

1. public 配下にアップロードした画像が保存されない

    原因
    php artisan storage:link をしていなかった

1. ファイルアップロードのテストで画像が正常に保存されているかの方法がピンとしなかった

    解決方法
    テスト時に使用する画像の名前をユニーク(uniqid で)な値をもたせ Storage から全ファイル取得し,preg_grep でマッチするかどうかを確認する。
    マッチした場合は true を返却し、テストすることができた

1. circle CI で PHP-GD の Jpeg Support が有効にならない

    原因
    ライブラリが不足していたことと、php インストール時のオプションに'--with-gd --with-jpeg-dir'がなかった

    解決
    .circleci/config.yml に以下の記載を載せる
    sudo apt-get install -y libjpeg62-turbo-dev libpng-dev
    sudo docker-php-ext-configure gd --with-gd --with-jpeg-dir=/usr/lib/
    sudo docker-php-ext-install gd

## 学んだこと

-   ワイヤーフレームを定義した方が、デザインなど迷走せずにすむ。
-   テストは機能追加時に、作成するのがよいと思った。既存の機能を編集した場合、他の機能に影響がないかすぐに確認できるため
-   git hub の issue を利用して、タスク管理すると便利

## 参考記事

### PHP

[blade で変数の存在確認する方法](https://qiita.com/mikimiki0055/items/24d96c72b5fb5e181297)

[PHP で文字数を制限し、超過分を『…』に置き換えるコード](https://spreadsheep.net/php%E3%81%A7%E6%96%87%E5%AD%97%E6%95%B0%E3%82%92%E5%88%B6%E9%99%90%E3%81%97%E3%80%81%E6%9C%AB%E5%B0%BE%E3%81%AB%E3%80%8E%E3%80%8F%E3%82%92%E8%BF%BD%E5%8A%A0%E3%81%99%E3%82%8B%E3%82%B3/)

[DB のトランザクション try...catch](https://www.it-swarm-ja.com/ja/php/laravel%EF%BC%9Adb-transaction%EF%BC%88%EF%BC%89%E3%81%A7try-catch%E3%82%92%E4%BD%BF%E7%94%A8%E3%81%99%E3%82%8B/1046624976/)

[Laravel 6 ローカライゼーション](https://laraweb.net/tutorial/6949/)

[Laravel で FatController を防ぐ５つの Tips](https://qiita.com/nunulk/items/6ed409345efb6ee4f660)

[Laravel によるアプリ開発のための逆引き Tips](https://qiita.com/kgsi/items/ccb1d70530f92268adfe)

[Intervention Image](http://image.intervention.io/getting_started/installation)

[Laravel バリデーションデータに前処理したい](https://qiita.com/toshikish/items/f38b691adbebd7ba7720)

[Laravel の Eloquent で LIKE を使う](https://laravel.hatenablog.com/entry/2013/11/23/004019)

[PHP インストールマニュアル](https://www.php.net/manual/ja/image.installation.php)

[Laravel の Blade ビューで現在の URL を取得する](https://pgmemo.tokyo/data/archives/1325.html)

[【Laravel】わりとよく使う Artisan コマンド集](https://qiita.com/sola-msr/items/a09b857c5e7f7c88d01d)

[[PHP/Laravel] Eloquent モデルで初期値(デフォルト値)を設定したいときは\$attributes を触ってなんとかする。](http://nisihunabasi.mods.jp/blog/?p=804)

### HTML or CSS or BootStrap

[マージンとパディングの違い](https://www.fenet.jp/dotnet/column/tool/2033/)

### テスト系

[Laravel7 でログイン画面を作って PHPUnit で動作確認する](https://engineer-lady.com/program_info/create-login-phpunit-laravel7/)

[誰でも簡単! CircleCI で PHPUnit を実行してみよう!!](https://qiita.com/KeisukeKudo/items/d058b359361e622dcc6f)

[【初心者向け】Laravel テストチュートリアル](https://blog.shonansurvivors.com/entry/laravel6-test)

### Vue

[vuex をまだ理解していない全人類に捧ぐ vuex を利用したコードの図解](https://qiita.com/fruitriin/items/42b0ebc5f8a524a0ae17)

[Laravel7 から Vue.js を使う最短レシピ](https://qiita.com/fruitriin/items/118c773b045101db7651)

[Laravel で Vuetify を使えるようにする](https://blog.proglearn.com/2020/09/05/%E3%80%902020%E5%B9%B49%E6%9C%88-%E7%8F%BE%E5%9C%A8%E3%80%91laravel%E3%81%A7vuetify%E3%82%92%E4%BD%BF%E3%81%88%E3%82%8B%E3%82%88%E3%81%86%E3%81%AB%E3%81%99%E3%82%8B%E5%85%A8%E6%89%8B%E9%A0%86/)

[input で選択した画像のプレビューを表示したい vue.js 利用](https://reffect.co.jp/vue/input-image-previes-vue-js#2)

[Vue.js redirection to another page](https://stackoverflow.com/questions/35664550/vue-js-redirection-to-another-page)

[Vue.js で Form の各要素を Component 化する際の覚え書き](https://qiita.com/ryo2132/items/2e3fcedaffeff9fc3967)

### JS

[async/await 入門](https://www.codegrid.net/articles/2017-async-await-1)

[キーボードのキーコード](https://javascript.programmer-reference.com/js-list-keycode/)
