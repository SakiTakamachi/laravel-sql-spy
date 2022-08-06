<?php

namespace LaravelSqlSpy\Handlers;

use Illuminate\Support\Collection;
use LaravelSqlSpy\DataTransferObjects\Report\GroupedQueryLogDto;
use LaravelSqlSpy\Singleton\ReportCollection;

abstract class GroupReports
{
    protected Collection $reports;

    public function __construct(
        ReportCollection $report_collection,
        protected Collection $grouped_report_collection,
    ) {
        $this->reports = $report_collection->getReports();
    }

    abstract public function handle(): void;

    public function get(): Collection
    {
        $this->handle();

        return $this->grouped_report_collection;
    }

    protected function pushGroupedReport(
        string $query,
        int $count,
        float $total_time,
        float $average_time,
        array $backtrace,
    ): void {
        $this->grouped_report_collection->push(new GroupedQueryLogDto(
            $query,
            $count,
            $total_time,
            $average_time,
            $backtrace,
        ));
    }
}