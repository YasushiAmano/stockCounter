<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withProviders([
        // 既存のプロバイダー
        Spatie\Permission\PermissionServiceProvider::class,
    ])
    ->withMiddleware(function (Middleware $middleware) {
        // middleware.phpの設定を読み込む
        $config = require __DIR__ . '/middleware.php';

        // エイリアスを登録
        $middleware->alias($config['aliases']);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
