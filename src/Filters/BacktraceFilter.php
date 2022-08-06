<?php

namespace LaravelSqlSpy\Filters;

class BacktraceFilter
{
    protected const EXCLUDE_PATHS = [
        '/vendor/laravel/framework/src/Illuminate/Support',
        '/vendor/laravel/framework/src/Illuminate/Database',
        '/vendor/laravel/framework/src/Illuminate/Events',
        'laravel-sql-spy',
    ];

    public static function filter(array $backtrace): array
    {
        $filtered_backtrace = [];

        foreach ($backtrace as $backtrace_item) {
            if (!self::isExcludeFile($backtrace_item['file'])) {
                $filtered_backtrace[] = $backtrace_item;
            }
        }

        $reverse_filtered_backtrace = array_reverse($filtered_backtrace);

        foreach ($reverse_filtered_backtrace as $index => $backtrace_item) {
            if (strpos($backtrace_item['file'], 'Controllers') !== false || strpos($backtrace_item['file'], 'ViewComposers') !== false) {
                break;
            }

            unset($reverse_filtered_backtrace[$index]);
        }

        if (!empty($reverse_filtered_backtrace)) {
            $filtered_backtrace = array_reverse($reverse_filtered_backtrace);
        }

        return array_filter($filtered_backtrace);
    }

    protected static function isExcludeFile(string $file_path): bool
    {
        $file_path = str_replace('\\', '/', $file_path);
        $file_path = realpath($file_path);

        foreach (self::EXCLUDE_PATHS as $exclude_path) {
            if (strpos($file_path, $exclude_path) !== false) {
                return true;
            }
        }

        return false;
    }
}
