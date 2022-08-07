<?php

namespace LaravelSqlSpy\Singleton;

use Illuminate\Support\Collection;
use LaravelSqlSpy\DataTransferObjects\Report\QueryLogDto;

class ReportCollection
{
    public function __construct(protected Collection $reports)
    {
        //
    }

    public function push(QueryLogDto $query_log_dto): void
    {
        $this->reports->push($query_log_dto);
    }

    public function getReports(): Collection
    {
        return $this->reports;
    }
}
