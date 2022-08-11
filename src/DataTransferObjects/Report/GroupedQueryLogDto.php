<?php

namespace LaravelSqlSpy\DataTransferObjects\Report;

class GroupedQueryLogDto
{
    public function __construct(
        protected string $query,
        protected int $count,
        protected float $totalTime,
        protected float $averageTime,
        protected array $backtrace,
    ) {
        //
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getTotalTime(): float
    {
        return $this->totalTime;
    }

    public function getAverageTime(): float
    {
        return $this->averageTime;
    }

    public function getBacktrace(): array
    {
        return $this->backtrace;
    }
}
