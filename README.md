# 環境構築

## 基本設定

### Octane

laravel/octane

Laravel Octane（オクタン）は、FrankenPHP、Open Swoole、Swoole、RoadRunnerなどの高性能なアプリケーションサーバを使用し、アプリケーションを提供することで、アプリケーションのパフォーマンスを向上させます。Octaneはアプリケーションを一度起動したら、メモリ内に保持し、そして超音速でリクエストを送り返します

### FrankenPHP

dunglas/frankenphp

FrankenPHPはGoで書かれたPHPアプリケーションサーバです。Early hints、Brotli、Zstandard圧縮といった最新のウェブ機能をサポートしています。Octane をインストールし、FrankenPHP をサーバとして選択すると、Octaneが自動的にFrankenPHPのバイナリをダウンロードしてインストールします。

起動しない場合下記を追加

```octane.php
'max_requests' => env('OCTANE_MAX_REQUESTS', 500),
'restart_worker_on_exit' => env('OCTANE_RESTART_WORKER', true),
'workers' => env('OCTANE_WORKERS', null),
```

```.env
OCTANE_MAX_REQUESTS=500
OCTANE_RESTART_WORKER=true
OCTANE_WORKERS=null
```

## 初期設定

Laravelはsrcディレクトリに配置しています。

srcの中で.env.base_sampleコピーして.envを作成してください。

FrankenPHPの仕様でコンテナー内では/appがルートディレクトリになります。

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
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'localhost',
            protocol: 'ws'  // WebSocketプロトコルを明示的に指定
        },
        watch: {
            usePolling: true  // ファイル変更の検知を確実にする
        },
        port: 5173,  // ポートを明示的に指定
    },
});
```

### 本番用ビルド

```sh
npm run build
```

## 備考

### vendorのコピー

コンテナー内のvendorをコピーする場合は、下記コマンドを使用します。

```sh
docker cp $(docker-compose ps -q php):/app/vendor ./src/
```

### jetstreamのルーティング


Jetstreamのルーティングを公開するには、下記コマンドを使用します。
jetstreamのルーティングは、src/routes/jetstream.phpに記述できるようになります。

```sh
php artisan vendor:publish --tag=jetstream-routes
```
