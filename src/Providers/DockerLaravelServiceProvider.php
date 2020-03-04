<?php

namespace WebArtisans\DockerLaravel\Providers;

use Illuminate\Support\ServiceProvider;
use WebArtisans\DockerLaravel\Commands\DockerRemoveCommand;
use WebArtisans\DockerLaravel\Commands\DockerServeCommand;
use WebArtisans\DockerLaravel\Commands\DockerStopCommand;

class DockerLaravelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/docker-laravel.php' , "docker-laravel"
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/docker-laravel.php' => config_path('docker-laravel.php'),
        ],  'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                DockerServeCommand::class,
                DockerStopCommand::class,
                DockerRemoveCommand::class,
            ]);
        }
    }
}
