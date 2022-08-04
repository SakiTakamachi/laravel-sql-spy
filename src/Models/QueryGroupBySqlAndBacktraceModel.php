<?php

namespace LaravelSqlSpy\Models;

use LaravelSqlSpy\Models\Model;
use LaravelSqlSpy\Models\Traits\Fields\SqlField;
use LaravelSqlSpy\Models\Traits\Fields\BacktraceField;
use LaravelSqlSpy\Models\Traits\Fields\QueryGroupField;

class QueryGroupBySqlAndBacktraceModel extends Model
{
    use SqlField, BacktraceField, QueryGroupField;
}