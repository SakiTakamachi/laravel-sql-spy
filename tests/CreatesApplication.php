<?php

namespace LaravelSqlSpy\Tests;

use Illuminate\Contracts\Console\Kernel;
use LaravelSqlSpy\LaravelSqlSpyServiceProvider;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $app->register(LaravelSqlSpyServiceProvider::class);

        return $app;
    }
}
