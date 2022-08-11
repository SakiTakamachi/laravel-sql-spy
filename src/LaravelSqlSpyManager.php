<?php

namespace LaravelSqlSpy;

use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LaravelSqlSpy\DataTransferObjects\Report\QueryLogDto;

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
        $formatedBindings = [];

        foreach ($bindings as $binding) {
            $formatedBindings[] = match (true) {
                is_string($binding)          => $binding,
                is_bool($binding)            => $binding ? '1' : '0',
                is_int($binding)             => (string) $binding,
                is_null($binding)            => 'NULL',
                $binding instanceof Carbon   => $binding->toDateTimeString(),
                $binding instanceof DateTime => $binding->format('Y-m-d H:i:s'),
                default                      => '?',
            };
        }

        return $formatedBindings;
    }

    protected function getBacktrace(): array
    {
        $backtrace = debug_backtrace(false, 100);

        $filteredBacktrace = [];

        foreach ($backtrace as $backtraceItem) {
            if (self::isBacktraceExcludeFile($backtraceItem['file'])) {
                continue;
            }

            if (!file_exists($backtraceItem['file'])) {
                throw new Exception('File "'.$backtraceItem['file'].'" not found.');
            }

            $filteredBacktrace[] = $backtraceItem;
        }

        $reverseFilteredBacktrace = array_reverse($filteredBacktrace);

        foreach ($reverseFilteredBacktrace as $index => $backtraceItem) {
            if (self::isBacktraceExcludeFile($backtraceItem['file'])) {
                break;
            }

            unset($reverseFilteredBacktrace[$index]);
        }

<<<<<<< HEAD
        if (!empty($reverseFilteredBacktrace)) {
            $filteredBacktrace = array_reverse($reverseFilteredBacktrace);
=======
        if (! empty($reverse_filtered_backtrace)) {
            $filtered_backtrace = array_reverse($reverse_filtered_backtrace);
>>>>>>> bc130008ba04c97ea832f4acb13d74af7f6b802b
        }

        $formatedBacktrace = [];

        foreach ($filteredBacktrace as $backtraceItem) {
            $filePath = realpath($backtraceItem['file']);
            $filePath = str_replace(base_path(), '', $filePath);
            $formatedBacktrace[] = sprintf('%s:%s', $filePath, $backtraceItem['line']);
        }

        return array_filter($formatedBacktrace);
    }

    protected function isBacktraceStartFile(string $filePath): bool
    {
        foreach (self::BACKTRACE_START_KEYWORDS as $keyword) {
            if (strpos($filePath, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    protected function isBacktraceExcludeFile(string $filePath): bool
    {
        $filePath = str_replace('\\', '/', $filePath);
        $filePath = realpath($filePath);

        foreach (self::BACKTRACE_EXCLUDE_KEYWORDS as $keyword) {
            if (strpos($filePath, $keyword) !== false) {
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
