<?php

namespace LaravelSqlSpy\Formatters;

use Carbon\Carbon;
use DateTime;

class BindingFormatter
{
    public static function format(array $bindings) : array
    {
        $formated_bindings = [];

        foreach ($bindings as $binding) {
            $formated_bindings[] = match(true){
                is_string($binding) => "'{$binding}'",
                is_bool($binding) => $binding ? '1' : '0',
                is_int($binding) => (string) $binding,
                is_null($binding) => 'NULL',
                $binding instanceof Carbon => "'{$binding->toDateTimeString()}'",
                $binding instanceof DateTime => "'{$binding->format('Y-m-d H:i:s')}'",
                default => '?',
            };
        }

        return $formated_bindings;
    }
}