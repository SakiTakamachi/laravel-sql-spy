<?php

namespace Sakiot\LaravelSqlSpy\Models\Traits;

trait ToArray
{
    public function toArray() : array
    {
        return (array) $this;
    }
}