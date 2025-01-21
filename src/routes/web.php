<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // デバッグ用のルートを追加
    Route::get('/debug-permission', function () {
        $user = auth()->user();
        dd([
            'user' => $user->name,
            'email' => $user->email,
            'roles' => $user->getRoleNames()->toArray(),
            'permissions' => $user->getAllPermissions()->pluck('name')->toArray(),
            'has_manager_permission' => $user->hasPermissionTo('view_manager_page'),
        ]);
    });

    // マネージャー用ルート
    Route::group([
        'prefix' => 'manager',
        'middleware' => 'permission:view_manager_page'
    ], function () {
        Route::resource('events', EventController::class);
    });

    // 管理者用ルート
    Route::group([
        'prefix' => 'admin',
        'middleware' => 'permission:view_admin_page'
    ], function () {
        Route::get('/index', function () {
            return '管理者ページにアクセスできました！';
        });
    });

    // ユーザー用ルート
    Route::group([
        'prefix' => 'user',
        'middleware' => 'permission:view_user_page'
    ], function () {
        Route::get('/index', function () {
            return 'ユーザーページにアクセスできました！';
        });
    });
});
