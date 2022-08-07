<?php

namespace LaravelSqlSpy;

class Config
{
    public static function isEnable(): bool
    {
        return config('app.debug') === true;
    }
}
