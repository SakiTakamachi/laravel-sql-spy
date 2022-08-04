<?php

namespace LaravelSqlSpy\Models;

use LaravelSqlSpy\Models\Traits\ToArray;
use LaravelSqlSpy\Models\Traits\ToCollection;

abstract class Model
{
    use ToArray, ToCollection;
}