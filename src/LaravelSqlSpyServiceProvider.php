<?php

namespace LaravelSqlSpy;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use LaravelSqlSpy\Http\Middleware\InjectLaravelSqlSpyMiddleware;
use LaravelSqlSpy\Singleton\ReportCollection;

class LaravelSqlSpyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        if (!$this->isEnable()) {
            return;
        }

        $this->dependencyInjection();
        $this->app->call([
            $this->app->make(LaravelSqlSpy::class),
            'listen',
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        if (!$this->isEnable()) {
            return;
        }

        $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'sql-spy');

        $kernel = $this->app[Kernel::class];
        $kernel->pushMiddleware(InjectLaravelSqlSpyMiddleware::class);
    }

    protected function dependencyInjection(): void
    {
        $this->app->singleton(ReportCollection::class);
    }

    protected function isEnable(): bool
    {
        return config('app.debug') === true;
    }
}
