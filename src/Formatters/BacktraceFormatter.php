<?php

namespace LaravelSqlSpy\Formatters;

class BacktraceFormatter
{
    public static function format(array $backtrace) : array
    {
        $formated_backtrace = [];

        foreach($backtrace as $backtrace_item){
            if(isset($backtrace_item['line']) && isset($backtrace_item['file'])){
                if(file_exists($backtrace_item['file'])){
                    $file_path = realpath($backtrace_item['file']);
                }
        
                $file_path = str_replace(base_path(), '', $file_path);
        
                $formated_backtrace[] = sprintf('%s:%s', $file_path, $backtrace_item['line']);
            }
        }

        return $formated_backtrace;
    }
}