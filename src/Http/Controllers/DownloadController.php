<?php

namespace Sakiot\LaravelSqlSpy\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Sakiot\LaravelSqlSpy\Utils\Session\SessionUtil;
use Sakiot\LaravelSqlSpy\Vos\CsvVo;

class DownloadController extends Controller
{
    public function csv(Request $request)
    {
        $session_data = SessionUtil::load();

        abort_if(!$session_data->hasData(), 404);

        $filename = CsvVo::fileBaseName() . $session_data->getPageName() . '_' . $session_data->spiedAt()->format('Ymd_His') . '.csv';

        $reports = $session_data->getReports();

        $callback = function() use ($reports){
            $stream = fopen('php://output', 'w');

            fputcsv($stream, CsvVo::groupBySqlAndBacktraceHeader());

            foreach($reports as $report){
                fputcsv($stream, [
                    $report->sql(),
                    $report->count(),
                    $report->totalTime(),
                    $report->averageTime(),
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