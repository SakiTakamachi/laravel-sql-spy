<?php

namespace LaravelSqlSpy\DataTransferObjects\Report;

use LaravelSqlSpy\DataTransferObjects\Report\QueryLogDto;

class GroupedQueryLogDto extends QueryLogDto
{
    public function __construct(
        protected string $query,
        protected array $bindings,
        protected float $time,
        protected array $backtrace,
        protected int $count,
    )
    {
        //
    }

    public function getCount() : int
    {
        return $this->count;
    }
}