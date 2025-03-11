<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ReservationController;


Route::get('/', function () {
    return view('calendar');
});

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');

// });

// 管理者用ルート
Route::group([
    'prefix' => 'admin',
    'middleware' => 'permission:view_admin_page'
], function () {
    Route::get('/index', function () {
        return '管理者ページにアクセスできました！';
    });
});

// マネージャー用ルート
Route::group([
    'prefix' => 'manager',
    'middleware' => 'permission:view_manager_page'
], function () {
    Route::get('events/past', [EventController::class, 'past'])->name('event.past');
    Route::resource('events', EventController::class); // 各メソッドに対応
});

// ユーザー用ルート
Route::group([
    'prefix' => 'user',
    'middleware' => 'permission:view_user_page'
], function () {
    Route::get('/index', function () {
        return 'ユーザーページにアクセスできました！';
    });
    Route::get('/dashboard', [ReservationController::class, 'dashboard'])->name('dashboard');
});

// ユーザー以上の権限を持つユーザー用ルート
Route::group([
    'prefix' => 'shared',
    'middleware' => 'permission:view_user_page|view_manager_page|view_admin_page'
], function () {
    Route::get('/dashboard', [ReservationController::class, 'dashboard'])->name('dashboard');
    Route::get('/{id}', [ReservationController::class, 'detail'])->name('events.detail');
    Route::post('/{id}', [ReservationController::class, 'reserve'])->name('events.reserve');
});
