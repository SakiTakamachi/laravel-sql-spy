<?php

namespace LaravelSqlSpy\Dtos\Report;

use Illuminate\Support\Collection;

class ReportSingletonDto
{
    protected Collection $reports;

    public function __construct()
    {
        $this->reports = collect();
    }

    public function reports() : Collection
    {
        return $this->reports;
    }
}