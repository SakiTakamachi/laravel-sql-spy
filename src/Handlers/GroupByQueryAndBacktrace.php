<?php

namespace LaravelSqlSpy\Handlers;

use LaravelSqlSpy\Handlers\GroupReports;

class GroupByQueryAndBacktrace extends GroupReports
{
    public function handle() : void
    {
        $this->reports
            ->groupBy([function($report){
                return $report->getQuery();
            }, function($report){
                return serialize($report->getBacktrace());
            }])->each(function($report_group_by_query, $query){
                $report_group_by_query->each(function($report_group_by_backtrace, $backtrace) use ($query){
                    $count = $report_group_by_backtrace->count();
                    $total_time = $report_group_by_backtrace->sum(function($report){
                        return $report->time();
                    });
                    $average_time = $count > 0 ? $total_time / $count : 0;

                    $this->pushGroupedReport(
                        $query,
                        $count,
                        $total_time,
                        $average_time,
                        unserialize($backtrace),
                    );
                });
            });
    }
}