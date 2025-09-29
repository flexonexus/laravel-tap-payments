<?php

namespace FlexoNexus\Tap;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use FlexoNexus\Tap\Http\TapClient;
use FlexoNexus\Tap\Contracts\TapGateway;
use FlexoNexus\Tap\Services\TapGatewayImpl;

class TapServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/tap.php', 'tap');

        $this->app->singleton(TapClient::class, function ($app) {
            $config = $app['config']->get('tap');
            $base = $config['endpoints'][$config['mode']] ?? $config['endpoints']['sandbox'];
            return new TapClient($base, $config['secret_key']);
        });

        $this->app->bind(TapGateway::class, function ($app) {
            return new TapGatewayImpl($app->make(TapClient::class));
        });
    }

    public function boot(): void
    {
        // publish config
        $this->publishes([
            __DIR__.'/../config/tap.php' => config_path('tap.php'),
        ], 'tap-config');

        // routes (webhook)
        $this->loadRoutesFrom(__DIR__.'/../routes/tap.php');
    }
}
