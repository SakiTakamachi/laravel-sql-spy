<?php

namespace LaravelSqlSpy\Models\Traits;

trait ToArray
{
    public function toArray() : array
    {
        return (array) $this;
    }
}