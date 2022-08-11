<?php

namespace LaravelSqlSpy\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelSqlSpy\Stores\SessionStore;
use LaravelSqlSpy\ValueObjects\CsvVo;

class DownloadController extends Controller
{
    public function csv(Request $request)
    {
        $sessionData = SessionStore::load();

        abort_if(!$sessionData->hasData(), 404);

        $filename = sprintf('%s%s_%s.csv', CsvVo::fileBaseName(), $sessionData->getPageName(), $sessionData->getSpiedAt()->format('Ymd_His'));

        $reports = $sessionData->getReports();

        $callback = function () use ($reports) {
            $stream = fopen('php://output', 'w');

            fputcsv($stream, CsvVo::groupBySqlAndBacktraceHeader());

            foreach ($reports as $report) {
                fputcsv($stream, [
                    $report->getQuery(),
                    $report->getCount(),
                    $report->getTotalTime(),
                    $report->getAverageTime(),
                    implode("\n", $report->getBacktrace()),
                ]);
            }

            fclose($stream);
        };

        $header = [
            'Content-Type' => 'application/octet-stream',
        ];

        return response()->streamDownload($callback, $filename, $header);
    }
}
