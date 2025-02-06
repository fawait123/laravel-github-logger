<?php

namespace Geekgarden\GithubLogger;

use Illuminate\Support\ServiceProvider;

class GithubLoggerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(GithubLogger::class, function ($app) {
            return new GithubLogger(
                config('github_error_reporter.repo'),
                config('github_error_reporter.token')
            );
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/github_error_reporter.php' => config_path('github_logger.php'),
        ]);
    }
}
