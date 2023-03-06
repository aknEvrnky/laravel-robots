<?php

namespace MadWeb\Robots;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class RobotsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected bool $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('robots', function () {
            return new Robots;
        });

        $this->app->alias('robots', Robots::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Robots::class, 'robots'];
    }
}
