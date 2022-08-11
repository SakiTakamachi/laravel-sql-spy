<?php

namespace LaravelSqlSpy\Handlers;

class GroupByQueryAndBacktrace extends GroupReports
{
    public function handle(): void
    {
        $this->reports
            ->groupBy([function ($report) {
                return $report->getQuery();
            }, function ($report) {
                return serialize($report->getBacktrace());
            }])->each(function ($reportGroupByQuery, $query) {
                $reportGroupByQuery->each(function ($reportGroupByBacktrace, $backtrace) use ($query) {
                    $count = $reportGroupByBacktrace->count();
                    $totalTime = $reportGroupByBacktrace->sum(function ($report) {
                        return $report->getTime();
                    });
                    $averageTime = $count > 0 ? $totalTime / $count : 0;

                    $this->pushGroupedReport(
                        $query,
                        $count,
                        $totalTime,
                        $averageTime,
                        unserialize($backtrace),
                    );
                });
            });
    }
}
