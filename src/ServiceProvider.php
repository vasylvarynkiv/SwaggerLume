<?php

namespace SwaggerLumen;

use SwaggerLume\Console\PublishCommand;
use SwaggerLume\Console\GenerateDocsCommand;
use SwaggerLume\Console\PublishViewsCommand;
use SwaggerLume\Console\PublishConfigCommand;
use Illuminate\Support\ServiceProvider as BaseProvider;

class ServiceProvider extends BaseProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $viewPath = __DIR__.'/../resources/views';
        $this->loadViewsFrom($viewPath, 'swagger-lumen');

        $this->app->router->group(['namespace' => 'SwaggerLumen'], function ($route) {
            require __DIR__.'/routes.php';
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__.'/../config/swagger-lumen.php';
        $this->mergeConfigFrom($configPath, 'swagger-lumen');

        $this->app->singleton('command.swagger-lumen.publish', function () {
            return new PublishCommand();
        });

        $this->app->singleton('command.swagger-lumen.publish-config', function () {
            return new PublishConfigCommand();
        });

        $this->app->singleton('command.swagger-lumen.publish-views', function () {
            return new PublishViewsCommand();
        });

        $this->app->singleton('command.swagger-lumen.generate', function () {
            return new GenerateDocsCommand();
        });

        $this->commands(
            'command.swagger-lumen.publish',
            'command.swagger-lumen.publish-config',
            'command.swagger-lumen.publish-views',
            'command.swagger-lumen.generate'
        );
    }
}
