<?php

namespace Sakiot\LaravelSqlSpy\Utils\Report;

class BacktraceUtil
{
    protected const EXCLUDE_PATHS = [
        '/vendor/laravel/framework/src/Illuminate/Support',
        '/vendor/laravel/framework/src/Illuminate/Database',
        '/vendor/laravel/framework/src/Illuminate/Events',
        '/packages/sakiot/sql-spy/'
    ];

    public static function parse(array $backtrace) : array
    {
        $parsed_backtrace = [];
        foreach($backtrace as $backtrace_item){
            $parsed_backtrace[] = self::parseTraceItem($backtrace_item);
        }

        $parsed_backtrace = array_filter($parsed_backtrace);
        $reverse_parsed_backtrace = array_reverse($parsed_backtrace);

        foreach($reverse_parsed_backtrace as $index => $reverse_backtrace_item){
            if(strpos($reverse_backtrace_item, 'Controllers') !== false || strpos($reverse_backtrace_item, 'ViewComposers') !== false){
                break;
            }

            unset($reverse_parsed_backtrace[$index]);
        }

        if(!empty($reverse_parsed_backtrace)){
            $parsed_backtrace = array_reverse($reverse_parsed_backtrace);
        }

        return $parsed_backtrace;
    }

    protected static function parseTraceItem(array $backtrace_item) : null|string
    {
        if (
            isset($backtrace_item['line']) &&
            isset($backtrace_item['file']) &&
            !self::isExcludeFile($backtrace_item['file'])
        ) {
            return self::format($backtrace_item['file'], $backtrace_item['line']);
        }

        return null;
    }

    protected static function isExcludeFile(string $file_path) : bool
    {
        $file_path = str_replace('\\', '/', $file_path);

        foreach(self::EXCLUDE_PATHS as $exclude_path){
            if(strpos($file_path, $exclude_path) !== false){
                return true;
            }
        }

        return false;
    }

    protected static function format(string $file_path, string $line) : string
    {
        if(file_exists($file_path)){
            $file_path = realpath($file_path);
        }

        $file_path = str_replace(base_path(), '', $file_path);

        return sprintf('%s:%s', $file_path, $line);
    }
}