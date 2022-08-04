<?php

namespace LaravelSqlSpy\Vos;

class SessionVo
{
    protected const SESSION_KEY = 'laravel-sql-spy';

    public static function key() : string
    {
        return self::SESSION_KEY;
    }
}