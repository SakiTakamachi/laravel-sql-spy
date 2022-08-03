<?php

namespace Sakiot\LaravelSqlSpy\Vos;

class SessionVo
{
    protected const SESSION_KEY = 'sakiot-sql-spy';

    public static function key() : string
    {
        return self::SESSION_KEY;
    }
}