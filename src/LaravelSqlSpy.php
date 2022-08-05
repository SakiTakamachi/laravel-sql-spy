<?php

namespace LaravelSqlSpy;

use Illuminate\Support\Facades\DB;
use LaravelSqlSpy\DataTransferObjects\Report\QueryLogDto;
use LaravelSqlSpy\Singleton\ReportCollection;
use LaravelSqlSpy\Formatters\BindingFormatter;
use LaravelSqlSpy\Formatters\BacktraceFormatter;
use LaravelSqlSpy\Filters\BacktraceFilter;

class LaravelSqlSpy
{
    public function __construct(protected ReportCollection $report_collection)
    {
        //
    }

    public function listen() : void
    {
        DB::listen(function ($query){
            $bindings = BindingFormatter::format($query->bindings);

            $backtrace = debug_backtrace(false, 100);
            $backtrace = BacktraceFilter::filter($backtrace);
            $backtrace = BacktraceFormatter::format($backtrace);

            $this->report_collection->push(new QueryLogDto(
                $query->sql,
                $bindings,
                $query->time,
                $backtrace,
            ));
        });
    }
}