# furima-app

## 環境構築

### Dockerビルド

```bash
git clone <リポジトリURL>
cd furima-app
docker compose up -d --build
```

### Laravel環境構築

```bash
docker compose exec php bash
composer install
cp .env.example .env
```
.envを開き環境変数を変更する
```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
```

## 使用技術(実行環境)

- PHP 8.x
- Laravel 8.x
- MySQL 8.0.26
- nginx 1.21.1

## ER図

<ER図の画像>

## URL

- 開発環境：http://localhost
- ユーザー登録：http://localhost/register
- phpMyAdmin：http://localhost:8080
