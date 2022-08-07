<?php

namespace LaravelSqlSpy\Tests;

use Laravel\BrowserKitTesting\TestCase as BaseTestCase;
use LaravelSqlSpy\Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $baseUrl = 'http://localhost';
}