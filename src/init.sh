#!/bin/bash
set -e

# composer.jsonが存在するか確認
if [ -f "composer.json" ]; then
    composer install
    composer require laravel/jetstream
    composer require laravel-lang/lang
    composer require laravel-lang/publisher
    composer require laravel/octane
    composer require --dev barryvdh/laravel-ide-helper
fi

# package.jsonが存在するか確認
if [ -f "package.json" ]; then
    npm install
    # --forceオプションを追加してプロンプトをスキップ
    php artisan jetstream:install livewire --force
    npm run build
fi

# Laravel Octaneを使用してFrankenPHPを実行
# exec php artisan octane:start --server=frankenphp
