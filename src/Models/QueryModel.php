<?php

namespace Sakiot\LaravelSqlSpy\Models;

use Sakiot\LaravelSqlSpy\Models\Model;
use Sakiot\LaravelSqlSpy\Models\Traits\Fields\SqlField;
use Sakiot\LaravelSqlSpy\Models\Traits\Fields\BindingField;
use Sakiot\LaravelSqlSpy\Models\Traits\Fields\TimeField;
use Sakiot\LaravelSqlSpy\Models\Traits\Fields\BacktraceField;

class QueryModel extends Model
{
    use SqlField, BindingField, TimeField, BacktraceField;
}