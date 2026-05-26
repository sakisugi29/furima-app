# furima-app

## 環境構築

### Dockerビルド

```bash
git clone https://github.com/sakisugi29/furima-app.git
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
- MailHog（メール認証）

## メール認証について

* 会員登録後、メール認証が必要です
* 認証メールはMailHogで確認できます
* MailHog画面：http://localhost:8025

## Stripe決済について
* カード払い選択時はStripeの決済画面に遷移します
* テスト用カード番号：4242 4242 4242 4242


## ER図

<img width="829" height="942" alt="フリマアプリER図 drawio" src="https://github.com/user-attachments/assets/f44cf22c-a08d-4e6f-afdf-ae5632d34fef" />



## URL

- 開発環境：http://localhost
- ユーザー登録：http://localhost/register
- phpMyAdmin：http://localhost:8080
- MailHog：http://localhost:8025
