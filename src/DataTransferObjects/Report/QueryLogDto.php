<?php

namespace LaravelSqlSpy\DataTransferObjects\Report;

class QueryLogDto
{
    public function __construct(
        protected string $query,
        protected array $bindings,
        protected float $time,
        protected array $backtrace,
    )
    {
        //
    }

    public function getQuery() : string
    {
        return $this->query;
    }

    public function getBindings() : array
    {
        return $this->bindings;
    }

    public function getTime() : float
    {
        return $this->time;
    }

    public function getBacktrace() : array
    {
        return $this->backtrace;
    }
}