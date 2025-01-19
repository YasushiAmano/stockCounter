<?php

use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Middleware\TrustProxies;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return [
    'web' => [
        // 既存のwebミドルウェア
    ],

    'api' => [
        // 既存のapiミドルウェア
    ],

    'aliases' => [
        // 既存のエイリアス
        'permission' => PermissionMiddleware::class,
        'role' => RoleMiddleware::class,
        'role_or_permission' => RoleOrPermissionMiddleware::class,
    ],
];
