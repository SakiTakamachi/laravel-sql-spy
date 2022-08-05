<?php

namespace LaravelSqlSpy\DataTransferObjects\Report;

class GroupedQueryLogDto
{
    public function __construct(
        protected string $query,
        protected int $count,
        protected float $total_time,
        protected float $average_time,
        protected array $backtrace,
    )
    {
        //
    }

    public function getQuery() : string
    {
        return $this->query;
    }

    public function getCount() : int
    {
        return $this->count;
    }

    public function getTotalTime() : float
    {
        return $this->total_time;
    }

    public function getAverageTime() : float
    {
        return $this->average_time;
    }

    public function getBacktrace() : array
    {
        return $this->backtrace;
    }
}