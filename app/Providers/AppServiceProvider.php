<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use App\Services\Socialite\X\XProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Register custom Socialite provider 'x' (Twitter / X OAuth2)
        Socialite::extend('x', function ($app) {
            $config = $app['config']['services.x'] ?? null;

            return new XProvider(
                $app['request'],
                $config['client_id'] ?? null,
                $config['client_secret'] ?? null,
                $config['redirect'] ?? null
            );
        });
    }
}
