<?php

use Illuminate\Support\Facades\Route;

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
});

Route::prefix('manager')
    ->middleware('can:manager-higher')->group(function () {
        Route::get('/index', function () {
            dd('manager');
        });
    });
Route::middleware('can:user-higher')->group(function () {
    Route::get('/index', function () {
        dd('user');
    });
});
Route::middleware('can:admin')->group(function () {
    Route::get('/index', function () {
        dd('admin');
    });
});
