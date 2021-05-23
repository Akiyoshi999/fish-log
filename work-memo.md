#

## 使用コマンド

### 作成系

artisan make:test UserRegisterTest

#### database

php artisan make:seeder UserSeeder
php artisan make:seeder ArticleSeeder
php artisan mek:factory ArticleFactory --model=Article

### 起動コマンド

npm run watch

### インストール系

composer require laravel/ui
php artisan ui bootstrap
php artisan ui vue --auth
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

## 苦戦したこと

## 参考記事

### PHP

[blade で変数の存在確認する方法](https://qiita.com/mikimiki0055/items/24d96c72b5fb5e181297)

[PHP で文字数を制限し、超過分を『…』に置き換えるコード
](https://spreadsheep.net/php%E3%81%A7%E6%96%87%E5%AD%97%E6%95%B0%E3%82%92%E5%88%B6%E9%99%90%E3%81%97%E3%80%81%E6%9C%AB%E5%B0%BE%E3%81%AB%E3%80%8E%E3%80%8F%E3%82%92%E8%BF%BD%E5%8A%A0%E3%81%99%E3%82%8B%E3%82%B3/)

[DB のトランザクション try...catch](https://www.it-swarm-ja.com/ja/php/laravel%EF%BC%9Adb-transaction%EF%BC%88%EF%BC%89%E3%81%A7try-catch%E3%82%92%E4%BD%BF%E7%94%A8%E3%81%99%E3%82%8B/1046624976/)

### テスト系

[Laravel7 でログイン画面を作って PHPUnit で動作確認する
](https://engineer-lady.com/program_info/create-login-phpunit-laravel7/)

[誰でも簡単! CircleCI で PHPUnit を実行してみよう!!
](https://qiita.com/KeisukeKudo/items/d058b359361e622dcc6f)

### Vue

[vuex をまだ理解していない全人類に捧ぐ vuex を利用したコードの図解
](https://qiita.com/fruitriin/items/42b0ebc5f8a524a0ae17)

[Laravel7 から Vue.js を使う最短レシピ
](https://qiita.com/fruitriin/items/118c773b045101db7651)
