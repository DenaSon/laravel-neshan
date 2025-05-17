<?php

namespace Denason\Neshan;

use Denason\Neshan\Contracts\StaticMapInterface;
use Denason\Neshan\Services\StaticMapService;
use Illuminate\Support\ServiceProvider;

class NeshanServiceProvider extends ServiceProvider
{
    public function register(): void
    {

        $this->mergeConfigFrom(__DIR__ . '/Config/neshan.php', 'neshan');


        $this->app->singleton(StaticMapInterface::class, function ($app) {
            $config = config('neshan.static_map');
            return new StaticMapService($config['api_key'], $config['base_url']);
        });


        $this->app->singleton(NeshanManager::class, function ($app) {
            return new NeshanManager($app);
        });
    }

    public function boot(): void
    {

        $this->publishes([
            __DIR__ . '/Config/neshan.php' => config_path('neshan.php'),
        ], 'config');


        if (file_exists(__DIR__ . '/Helpers/ResponseFormatter.php')) {
            require_once __DIR__ . '/Helpers/ResponseFormatter.php';
        }


        //$this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
    }
}
