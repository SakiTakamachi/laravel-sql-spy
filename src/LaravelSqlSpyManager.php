<?php

namespace LaravelSqlSpy;

use Illuminate\Support\Facades\DB;
use LaravelSqlSpy\DataTransferObjects\Report\QueryLogDto;
use Exception;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Collection;

class LaravelSqlSpyManager
{
    protected static array $reports = [];
    protected const BACKTRACE_START_KEYWORDS = [
        'Controllers',
        'ViewComposers',
    ];
    protected const BACKTRACE_EXCLUDE_KEYWORDS = [
        '/vendor/laravel/framework/src/Illuminate/Support',
        '/vendor/laravel/framework/src/Illuminate/Database',
        '/vendor/laravel/framework/src/Illuminate/Events',
        'laravel-sql-spy',
    ];

    public function logging(): void
    {
        DB::listen(function ($query) {
            self::$reports[] = new QueryLogDto(
                $query->sql,
                $this->formatBindings($query->bindings),
                $query->time,
                $this->getBacktrace(),
            );
        });
    }

    protected function formatBindings(array $bindings): array
    {
        $formated_bindings = [];

        foreach ($bindings as $binding) {
            $formated_bindings[] = match (true) {
                is_string($binding)          => $binding,
                is_bool($binding)            => $binding ? '1' : '0',
                is_int($binding)             => (string) $binding,
                is_null($binding)            => 'NULL',
                $binding instanceof Carbon   => $binding->toDateTimeString(),
                $binding instanceof DateTime => $binding->format('Y-m-d H:i:s'),
                default                      => '?',
            };
        }

        return $formated_bindings;
    }

    protected function getBacktrace(): array
    {
        $backtrace = debug_backtrace(false, 100);

        $filtered_backtrace = [];

        foreach ($backtrace as $backtrace_item) {
            if(self::isBacktraceExcludeFile($backtrace_item['file'])){
                continue;
            }

            if (!file_exists($backtrace_item['file'])) {
                throw new Exception('File "'.$backtrace_item['file'].'" not found.');
            }

            $filtered_backtrace[] = $backtrace_item;
        }

        $reverse_filtered_backtrace = array_reverse($filtered_backtrace);

        foreach ($reverse_filtered_backtrace as $index => $backtrace_item) {
            if(self::isBacktraceExcludeFile($backtrace_item['file'])){
                break;
            }

            unset($reverse_filtered_backtrace[$index]);
        }

        if (!empty($reverse_filtered_backtrace)) {
            $filtered_backtrace = array_reverse($reverse_filtered_backtrace);
        }

        $formated_backtrace = [];

        foreach($filtered_backtrace as $backtrace_item){
            $file_path = realpath($backtrace_item['file']);
            $file_path = str_replace(base_path(), '', $file_path);
            $formated_backtrace[] = sprintf('%s:%s', $file_path, $backtrace_item['line']);
        }

        return array_filter($formated_backtrace);
    }

    protected function isBacktraceStartFile(string $file_path): bool
    {
        foreach (self::BACKTRACE_START_KEYWORDS as $keyword) {
            if (strpos($file_path, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    protected function isBacktraceExcludeFile(string $file_path): bool
    {
        $file_path = str_replace('\\', '/', $file_path);
        $file_path = realpath($file_path);

        foreach (self::BACKTRACE_EXCLUDE_KEYWORDS as $keyword) {
            if (strpos($file_path, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    public function getReports(): Collection
    {
        return new Collection(self::$reports);
    }
}
