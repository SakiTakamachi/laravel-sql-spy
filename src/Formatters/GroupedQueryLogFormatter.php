<?php

namespace LaravelSqlSpy\Formatters;

class GroupedQueryLogFormatter
{
    public static function parse(mixed $binding): string
    {
        return match (true) {
            is_string($binding)          => "'{$binding}'",
            is_bool($binding)            => $binding ? '1' : '0',
            is_int($binding)             => (string) $binding,
            is_null($binding)            => 'NULL',
            $binding instanceof Carbon   => "'{$binding->toDateTimeString()}'",
            $binding instanceof DateTime => "'{$binding->format('Y-m-d H:i:s')}'",
            default                      => '?',
        };
    }
}
