<?php

namespace Denason\Neshan;

use Denason\Neshan\Contracts\StaticMapInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Application;

/**
 * Class NeshanManager
 *
 * Central manager for accessing different Neshan map services through the Laravel service container.
 * This class acts as a facade-friendly gateway to retrieve service instances like StaticMap.
 *
 * Example usage:
 * ```
 * $mapService = app(NeshanManager::class)->staticMap();
 * $url = $mapService->generate(...);
 * ```
 *
 * @package Denason\Neshan
 */
class NeshanManager
{
    /**
     * The Laravel application instance.
     *
     * @var Application
     */
    protected Application $app;

    /**
     * Create a new NeshanManager instance.
     *
     * @param Application $app The Laravel application container
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Get the StaticMap service instance.
     *
     * @return StaticMapInterface The service responsible for generating static maps
     *
     * @throws BindingResolutionException If the StaticMapInterface cannot be resolved from the container
     */
    public function staticMap(): StaticMapInterface
    {
        return $this->app->make(StaticMapInterface::class);
    }
}
