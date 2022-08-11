<?php

namespace LaravelSqlSpy\Handlers;

use Illuminate\Support\Collection;
use LaravelSqlSpy\DataTransferObjects\Report\GroupedQueryLogDto;
use LaravelSqlSpy\LaravelSqlSpyManager;

abstract class GroupReports
{
    protected Collection $reports;

    public function __construct(
        LaravelSqlSpyManager $manager,
        protected Collection $groupedReportCollection,
    ) {
        $this->reports = $manager->getReports();
    }

    abstract public function handle(): void;

    public function get(): Collection
    {
        $this->handle();

        return $this->groupedReportCollection;
    }

    protected function pushGroupedReport(
        string $query,
        int $count,
        float $totalTime,
        float $averageTime,
        array $backtrace,
    ): void {
        $this->groupedReportCollection->push(new GroupedQueryLogDto(
            $query,
            $count,
            $totalTime,
            $averageTime,
            $backtrace,
        ));
    }
}
