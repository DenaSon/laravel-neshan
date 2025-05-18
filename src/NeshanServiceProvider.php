<?php

namespace Denason\Neshan;

use Denason\Neshan\Contracts\SearchInterface;
use Denason\Neshan\Contracts\StaticMapInterface;

use Denason\Neshan\Services\StaticMapService;
use Denason\Neshan\Services\SearchService;
use Illuminate\Support\ServiceProvider;

class NeshanServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Merge default config
        $this->mergeConfigFrom(__DIR__ . '/Config/neshan.php', 'neshan');

        // Register StaticMapService
        $this->app->singleton(StaticMapInterface::class, function ($app) {
            $config = config('neshan.static_map');
            return new StaticMapService($config['api_key'], $config['base_url']);
        });

        // Register SearchService
        $this->app->singleton(SearchInterface::class, function ($app) {
            $config = config('neshan.search');
            return new SearchService($config['api_key'], $config['base_url']);
        });

        // Optionally register a manager if using multiple services centrally
        $this->app->singleton(NeshanManager::class, function ($app) {
            return new NeshanManager($app);
        });
    }

    public function boot(): void
    {
        // Publish config file
        $this->publishes([
            __DIR__ . '/Config/neshan.php' => config_path('neshan.php'),
        ], 'config');

        // Load helpers if available
        if (file_exists(__DIR__ . '/Helpers/ResponseFormatter.php')) {
            require_once __DIR__ . '/Helpers/ResponseFormatter.php';
        }


         $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
    }
}
