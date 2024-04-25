# logmansion-app
Logmansion's smartphone application\


Log Mansion (仮)の開発資産です。

## 環境情報
Laravel 9.48
PHP     8.1
MySQL   8.0

## 開発環境構築

まずは以下手順で必要なファイルやディレクトリを生成する。（このディレクトリ、ファイルは環境に依存するため、Gitの管理外にしているため）

``` bash
# Tạo thư mục lưu file log
$ mkdir ./docker/nginx/log

# Tạo một thư mục được sử dụng bởi MySQL, bạn sẽ không thể git add thư mục này trừ khi bạn bỏ qua nó
$ mkdir ./docker/mysql

# Tạo các file bị bỏ qua nếu chúng không tồn tại khi được quản lý trên github
$ echo '' >> ./storage/logs/laravel.log

#thần chú Laravel
$ cp .env.example .env

### 初回実行コマンド

マイグレーションファイルがあるので、DockerのコンテナにSSH接続をしてマイグレーションを実行してください。

```bash
# Dockerコンテナ内にSSH接続
docker exec -it log-mansion-app bash


# Composerでライブラリをインストール
composer install

# keyの読み込みを行う
php artisan key:generate

# publicとstorageフォルダのリンク
php artisan storage:link

# マイグレーションを実行
php artisan migrate --seed

or
 
# シーダーを実行
php artisan db:seed
```

### 動作確認

ブラウザで`http://localhost`にアクセスすれば確認ができる。
User Login

email : superadmin@propolife.co.jp
password : super1234

email : admin@propolife.co.jp
password : admin1234