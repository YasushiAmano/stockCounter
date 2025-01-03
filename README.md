# 環境構築

## FrankenPHP

dunglas/frankenphp:1

## 初期設定

Laravelはsrcディレクトリに配置しています。

srcの中で.env.base_sampleコピーして.envを作成してください。

## Dockerを起動

```sh
docker compose up -d
```

### アプリケーションキーの生成

.envのAPP_KEYを生成します。

以下のコマンドは、コンテナー内で実行してください。

```sh
php artisan key:generate
```

### マイグレーションの実行

```sh
php artisan migrate
```


#### セッションテーブルの作成（.envでSESSION_DRIVER=databaseを使用している場合）

```sh
php artisan session:table
php artisan migrate
```

## IDE Helper（開発環境のみ）

```sh
# PHPDoc生成
php artisan ide-helper:generate
# モデルのPHPDoc生成
php artisan ide-helper:models -N
# DBのPHPDoc生成
php artisan ide-helper:meta
```

### Jetstream（高機能な認証）

Jetstreamは、 ログイン、新規登録、メール検証、２段階認証、セッション管理、APIサポート(Laravel Sanctum)、チーム管理などをサポートしています。

Laravelの初期画面の右上にLoginとRegisterのリンクがあります。
Registerから管理者を作成してください。

Jetstreamの初期化は、コンテナー内で実行してください。

```sh
composer require laravel/jetstream
php artisan jetstream:install livewire
```

## アセットのビルド

### npmパッケージのインストール

```sh
npm install
```

### 開発時のアセットビルド

```sh
npm run dev
```

Viteの開発サーバーが正常に起動すると、ターミナルで待ち受け状態になります。

vite.config.jsのVITE_DEV_SERVER_URLを.envに設定。

```sh
VITE_DEV_SERVER_URL=http://localhost:5173
```

また、vite.config.jsのserver.hmr.hostをlocalhostに設定してください。

```js
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'localhost'
        },
    },
});
```

### 本番用ビルド

```sh
npm run build
```
