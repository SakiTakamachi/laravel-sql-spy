<?php

namespace LaravelSqlSpy\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use LaravelSqlSpy\Stores\SessionStore;
use LaravelSqlSpy\ValueObjects\CsvVo;

class DownloadController extends Controller
{
    public function csv(Request $request)
    {
        $session_data = SessionStore::load();

        abort_if(!$session_data->hasData(), 404);

        $filename = sprintf('%s%s_%s.csv', CsvVo::fileBaseName(), $session_data->getPageName(), $session_data->spiedAt()->format('Ymd_His'));

        $reports = $session_data->getReports();

        $callback = function() use ($reports){
            $stream = fopen('php://output', 'w');

            fputcsv($stream, CsvVo::groupBySqlAndBacktraceHeader());

            foreach($reports as $report){
                fputcsv($stream, [
                    $report->getQuery(),
                    $report->getCount(),
                    $report->getTotalTime(),
                    $report->getAverageTime(),
                    implode("\n", $report->backtrace()),
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