<?php

namespace LaravelSqlSpy;

use Illuminate\Support\Facades\DB;
use LaravelSqlSpy\Models\QueryModel;
use LaravelSqlSpy\Models\QueryGroupBySqlAndBacktraceModel;
use LaravelSqlSpy\Repositories\ReportRepository;
use LaravelSqlSpy\Utils\Report\BindingUtil;
use LaravelSqlSpy\Utils\Report\BacktraceUtil;

class LaravelSqlSpy
{
    public function __construct(protected ReportRepository $report_repository)
    {
        //
    }

    public function listen() : void
    {
        DB::listen(function ($query){
            $query_model = app()->make(QueryModel::class);

            $query_model->sql($query->sql);

            /*
            foreach ($query->bindings as $binding) {
                $query_model->bindings(BindingUtil::parse($binding));
            }
            */

            $query_model->time($query->time);

            $backtrace = debug_backtrace(false, 100);
            $query_model->backtrace(BacktraceUtil::parse($backtrace));

            $this->report_repository->collection()->push($query_model);
        });
    }
}