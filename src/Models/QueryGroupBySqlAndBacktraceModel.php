<?php

namespace Sakiot\LaravelSqlSpy\Models;

use Sakiot\LaravelSqlSpy\Models\Model;
use Sakiot\LaravelSqlSpy\Models\Traits\Fields\SqlField;
use Sakiot\LaravelSqlSpy\Models\Traits\Fields\BacktraceField;
use Sakiot\LaravelSqlSpy\Models\Traits\Fields\QueryGroupField;

class QueryGroupBySqlAndBacktraceModel extends Model
{
    use SqlField, BacktraceField, QueryGroupField;
}