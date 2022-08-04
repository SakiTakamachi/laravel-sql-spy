<?php

namespace LaravelSqlSpy\Vos;

class CsvVo
{
    protected const FILE_BASE_NAME = 'LaravelSqlSpy_';
    protected const GROUP_BY_SQL_AND_BACKTRACE_HEADER = [
        'Query',
        'Count',
        'TotalTime(ms)',
        'AverageTime(ms)',
        'Backtrace',
    ];

    public static function fileBaseName() : string
    {
        return self::FILE_BASE_NAME;
    }

    public static function groupBySqlAndBacktraceHeader() : array
    {
        return self::GROUP_BY_SQL_AND_BACKTRACE_HEADER;
    }
}