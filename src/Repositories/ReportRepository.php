<?php

namespace LaravelSqlSpy\Repositories;

use Illuminate\Support\Collection;
use LaravelSqlSpy\Dtos\Report\ReportSingletonDto;
use LaravelSqlSpy\Models\QueryGroupBySqlAndBacktraceModel;

class ReportRepository
{
    protected Collection $reports;

    public function __construct(ReportSingletonDto $report_dto)
    {
        $this->reports = $report_dto->reports();
    }

    public function collection() : Collection
    {
        return $this->reports;
    }

    public function groupBySqlAndBacktrace() : array
    {
        $total_data = [];

        $this->reports
            ->groupBy([function($report){
                return $report->sql();
            }, function($report){
                return serialize($report->backtrace());
            }])->each(function($report_group_by_sql, $sql) use (&$total_data){
                $report_group_by_sql->each(function($report_group_by_backtrace, $backtrace) use ($sql, &$total_data){
                    $report_model = app()->make(QueryGroupBySqlAndBacktraceModel::class);

                    $report_model->sql($sql);
                    $report_model->count($report_group_by_backtrace->count());
                    $report_model->totalTime($report_group_by_backtrace->sum(function($report){
                        return $report->time();
                    }));
                    $report_model->backtrace(unserialize($backtrace));

                    $total_data[] = $report_model;
                });
            });

        return $total_data;
    }
}