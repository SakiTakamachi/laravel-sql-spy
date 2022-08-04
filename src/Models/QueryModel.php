<?php

namespace LaravelSqlSpy\Models;

use LaravelSqlSpy\Models\Model;
use LaravelSqlSpy\Models\Traits\Fields\SqlField;
use LaravelSqlSpy\Models\Traits\Fields\BindingField;
use LaravelSqlSpy\Models\Traits\Fields\TimeField;
use LaravelSqlSpy\Models\Traits\Fields\BacktraceField;

class QueryModel extends Model
{
    use SqlField, BindingField, TimeField, BacktraceField;
}