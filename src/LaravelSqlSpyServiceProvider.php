<?php

namespace LaravelSqlSpy;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use LaravelSqlSpy\LaravelSqlSpy;
use LaravelSqlSpy\Models\QueryModel;
use LaravelSqlSpy\Models\QueryGroupBySqlAndBacktraceModel;
use LaravelSqlSpy\Dtos\Report\ReportSingletonDto;
use LaravelSqlSpy\Repositories\ReportRepository;
use LaravelSqlSpy\Http\Middleware\InjectLaravelSqlSpyMiddleware;

class LaravelSqlSpyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() : void
    {
        if(!$this->isEnable()){
            return;
        }

        $this->dependencyInjection();
        $this->app->make(LaravelSqlSpy::class)->listen();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() : void
    {
        if(!$this->isEnable()){
            return;
        }

        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sql-spy');

        $kernel = $this->app[Kernel::class];
        $kernel->pushMiddleware(InjectLaravelSqlSpyMiddleware::class);
    }

    protected function dependencyInjection() : void
    {
        $this->app->bind(QueryModel::class);

        $this->app->bind(QueryGroupBySqlAndBacktraceModel::class);

        $this->app->singleton(ReportSingletonDto::class);

        $this->app->bind(ReportRepository::class, function ($app) {
            return new ReportRepository($app->make(ReportSingletonDto::class));
        });

        $this->app->bind(LaravelSqlSpy::class, function ($app) {
            return new LaravelSqlSpy($app->make(ReportRepository::class));
        });
    }

    protected function isEnable() : bool
    {
        return config('app.debug') === true;
    }
}
