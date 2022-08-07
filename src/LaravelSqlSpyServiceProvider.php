<?php

namespace LaravelSqlSpy;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use LaravelSqlSpy\Middleware\InjectLaravelSqlSpyMiddleware;

class LaravelSqlSpyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        if (!Config::isEnable()) {
            return;
        }

        $this->app->call([
            $this->app->make(LaravelSqlSpyManager::class),
            'logging',
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        if (!Config::isEnable()) {
            return;
        }

        $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'sql-spy');

        $kernel = $this->app[Kernel::class];
        $kernel->pushMiddleware(InjectLaravelSqlSpyMiddleware::class);
    }
}
