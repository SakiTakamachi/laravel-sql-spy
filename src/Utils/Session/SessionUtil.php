<?php

namespace Sakiot\LaravelSqlSpy\Utils\Session;

use Illuminate\Http\Request;
use Sakiot\LaravelSqlSpy\Repositories\ReportRepository;
use Sakiot\LaravelSqlSpy\Vos\RouteVo;
use Sakiot\LaravelSqlSpy\Vos\SessionVo;
use Sakiot\LaravelSqlSpy\Dtos\Session\SessionDto;
use Carbon\Carbon;

class SessionUtil
{
    public static function save(Request $request) : void
    {
        $route_name = $request?->route()?->getName();
        if(is_null($route_name) || $route_name === RouteVo::csvDownloadRouteNameFull()){
            return;
        }

        $page = $route_name ?: 'unknown';
        $page = str_replace('.', '_', $page);

        $reports = app()->make(ReportRepository::class)->groupBySqlAndBacktrace();

        $session_data = new SessionDto($page, $reports, Carbon::now());

        session()->put(SessionVo::key(), serialize($session_data));
        session()->save();
    }

    public static function load() : SessionDto
    {
        return unserialize(session()->get(SessionVo::key(), serialize(new SessionDto('', [], null, false))));
    }
}