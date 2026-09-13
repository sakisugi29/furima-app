# furima-app

## プロジェクト概要
フリマアプリのクローンアプリケーションです。商品の出品・購入・いいね・コメント機能などを実装しています。

## 使用技術（実行環境）
- PHP 8.x
- Laravel 8.x
- MySQL 8.0.26
- nginx 1.21.1
- MailHog（メール認証）
- Stripe（決済）

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

`.env`を開き、下記の「.env設定」を参考に環境変数を設定してください。

```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
```

## .env設定

### DB接続
Docker Compose経由でmysqlコンテナに接続します。`.env.example`に記載の値のまま利用できます。

```dotenv
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_user
```

### メール認証について
MailHogを使用しています。`MAIL_FROM_ADDRESS`は`null`のままだとメール送信エラーになるため、必ず何らかのメールアドレスを設定してください。

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=example@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

設定後、会員登録をすると認証メールが送信されます。以下のURLからMailHogの管理画面を開き、メール本文内のリンクから認証を完了してください。

- MailHog管理画面：http://localhost:8025

### Stripeについて
支払い方法で「カード払い」を選択した場合のみ、Stripeの決済画面に遷移します。以下を設定してください。

```dotenv
STRIPE_KEY=pk_test_xxxxxxxx
STRIPE_SECRET=sk_test_xxxxxxxx
```

テスト用カード番号：4242 4242 4242 4242（有効期限・セキュリティコードは任意の未来日付・3桁で入力可能）

参考：[Stripe公式ドキュメント](https://docs.stripe.com/payments/checkout?locale=ja-JP)

## テーブル仕様

### usersテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| name | varchar(255) |  |  | ◯ |  |
| email | varchar(255) |  | ◯ | ◯ |  |
| email_verified_at | timestamp |  |  |  |  |
| password | varchar(255) |  |  | ◯ |  |
| remember_token | varchar(100) |  |  |  |  |
| created_at | timestamp |  |  |  |  |
| updated_at | timestamp |  |  |  |  |

### itemsテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| user_id | bigint |  |  | ◯ | users(id) |
| item_image | varchar(255) |  |  | ◯ |  |
| item_name | varchar(255) |  |  | ◯ |  |
| brand_name | varchar(255) |  |  |  |  |
| price | int |  |  | ◯ |  |
| description | varchar(255) |  |  | ◯ |  |
| condition | varchar(255) |  |  | ◯ |  |
| status | varchar(255) |  |  | ◯ |  |
| created_at | timestamp |  |  |  |  |
| updated_at | timestamp |  |  |  |  |

### categoriesテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| name | varchar(255) |  |  | ◯ |  |
| created_at | timestamp |  |  |  |  |
| updated_at | timestamp |  |  |  |  |

### item_categoriesテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| item_id | bigint |  |  | ◯ | items(id) |
| category_id | bigint |  |  | ◯ | categories(id) |

### likesテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| item_id | bigint |  |  | ◯ | items(id) |
| user_id | bigint |  |  | ◯ | users(id) |
| created_at | timestamp |  |  |  |  |
| updated_at | timestamp |  |  |  |  |

### commentsテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| item_id | bigint |  |  | ◯ | items(id) |
| user_id | bigint |  |  | ◯ | users(id) |
| body | varchar(255) |  |  | ◯ |  |
| created_at | timestamp |  |  |  |  |
| updated_at | timestamp |  |  |  |  |

### purchasesテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| item_id | bigint |  |  | ◯ | items(id) |
| user_id | bigint |  |  | ◯ | users(id) |
| payment_method | varchar(255) |  |  | ◯ |  |
| shipping_address | varchar(255) |  |  | ◯ |  |
| created_at | timestamp |  |  |  |  |
| updated_at | timestamp |  |  |  |  |

### addressesテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| user_id | bigint |  |  | ◯ | users(id) |
| address | varchar(255) |  |  | ◯ |  |
| postal_code | varchar(255) |  |  | ◯ |  |
| building | varchar(255) |  |  |  |  |
| created_at | timestamp |  |  |  |  |
| updated_at | timestamp |  |  |  |  |

### profilesテーブル
| カラム名 | 型 | primary key | unique key | not null | foreign key |
| --- | --- | --- | --- | --- | --- |
| id | bigint | ◯ |  | ◯ |  |
| user_id | bigint |  |  | ◯ | users(id) |
| profile_image | varchar(255) |  |  |  |  |
| postal_code | varchar(255) |  |  | ◯ |  |
| address | varchar(255) |  |  | ◯ |  |
| building | varchar(255) |  |  |  |  |
| created_at | timestamp |  |  |  |  |
| updated_at | timestamp |  |  |  |  |

## ER図
[furima_app_ER図.pdf](https://github.com/user-attachments/files/32159414/furima_app_ER.pdf)


## テストアカウント
name: テストユーザー1
email: test1@example.com
password: password

-------------------------

name: テストユーザー2
email: test2@example.com
password: password

## PHPUnitを利用したテストに関して
```bash
docker compose exec php bash
php artisan migrate:fresh --env=testing
php artisan test
```
※`.env.testing`にもDB接続情報とStripeのAPIキーを設定してください。

## URL
- 開発環境：http://localhost
- ユーザー登録：http://localhost/register
- phpMyAdmin：http://localhost:8080
- MailHog：http://localhost:8025
