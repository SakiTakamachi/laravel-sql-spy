<?php

namespace LaravelSqlSpy\Handler;

use Illuminate\Support\Collection;
use LaravelSqlSpy\Singleton\ReportCollection;
use LaravelSqlSpy\DataTransferObjects\Report\GroupedQueryLogDto;

abstract class GroupReports
{
    protected Collection $reports;

    public function __construct(
        ReportCollection $report_collection,
        protected Collection $grouped_report_collection,
    )
    {
        $this->reports = $report_collection->getReports();
    }

    abstract public function handle() : void;

    public function get() : Collection
    {
        $this->handle();
        return $this->grouped_report_collection;
    }

    protected function pushGroupedReport(
        string $query,
        array $bindings,
        float $time,
        array $backtrace,
        int $count,
    ) : void
    {
        $this->grouped_report_collection->push(new GroupedQueryLogDto(
            $query,
            $bindings,
            $time,
            $backtrace,
            $count,
        ));
    }
}