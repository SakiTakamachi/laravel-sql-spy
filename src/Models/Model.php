<?php

namespace Sakiot\LaravelSqlSpy\Models;

use Sakiot\LaravelSqlSpy\Models\Traits\ToArray;
use Sakiot\LaravelSqlSpy\Models\Traits\ToCollection;

abstract class Model
{
    use ToArray, ToCollection;
}