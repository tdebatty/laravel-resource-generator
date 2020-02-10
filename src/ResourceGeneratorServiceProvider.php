<?php

namespace tdebatty\LaravelResourceGenerator;

use Illuminate\Support\ServiceProvider;

/**
 * Description of ResourceGeneratorServiceProvider
 *
 * @author tibo
 */
class ResourceGeneratorServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(
            'command.resource-generator.generate',
            function ($app) {
                return new GeneratorCommand($app['config'], $app['files']);
            }
        );

        $this->commands(
            'command.resource-generator.generate'
        );
    }

    public function provides()
    {
        return ['command.resource-generator.generate'];
    }
}
