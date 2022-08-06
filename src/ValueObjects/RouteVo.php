<?php

namespace LaravelSqlSpy\ValueObjects;

class RouteVo
{
    protected const PREFIX = '_laravel_sql-spy';
    protected const CSV_DOWNLOAD_ROUTE_NAME = 'download.csv';
    protected const CSV_DOWNLOAD_PATH = 'download/csv';

    public static function prefix(): string
    {
        return self::PREFIX;
    }

    public static function csvDownloadRouteName(): string
    {
        return self::CSV_DOWNLOAD_ROUTE_NAME;
    }

    public static function csvDownloadRouteNameFull(): string
    {
        return self::PREFIX.'.'.self::CSV_DOWNLOAD_ROUTE_NAME;
    }

    public static function csvDownloadPath(): string
    {
        return self::CSV_DOWNLOAD_PATH;
    }
}
