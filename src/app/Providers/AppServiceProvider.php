<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('ASSET_URL')) {
            URL::forceRootUrl(env('APP_URL'));
            URL::forceScheme('http');
        }

        // 強制的にアセットURLをlocalhostに設定
        $this->app['url']->forceRootUrl(env('APP_URL', 'http://localhost'));
    }
}
