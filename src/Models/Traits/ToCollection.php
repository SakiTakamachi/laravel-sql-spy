<?php

namespace Sakiot\LaravelSqlSpy\Models\Traits;

use Illuminate\Support\Collection;

trait ToCollection
{
    public function toCollection() : Collection
    {
        return collect($this->toArray());
    }
}