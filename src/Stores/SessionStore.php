<?php

namespace LaravelSqlSpy\Stores;

use Illuminate\Http\Request;
use LaravelSqlSpy\Handlers\GroupByQueryAndBacktrace;
use LaravelSqlSpy\ValueObjects\RouteVo;
use LaravelSqlSpy\ValueObjects\SessionVo;
use LaravelSqlSpy\DataTransferObjects\Session\SessionDto;
use Carbon\Carbon;

class SessionStore
{
    public static function save(Request $request) : void
    {
        $route_name = $request?->route()?->getName();

        if(is_null($route_name) || $route_name === RouteVo::csvDownloadRouteNameFull()){
            return;
        }

        $page = $route_name ?: 'unknown';
        $page = str_replace('.', '_', $page);

        $reports = app()->make(GroupByQueryAndBacktrace::class)->get();

        session()->put(SessionVo::key(), serialize(new SessionDto($page, $reports->toArray(), Carbon::now())));
        session()->save();
    }

    public static function load() : SessionDto
    {
        return unserialize(session()->get(SessionVo::key(), serialize(new SessionDto('', [], null, false))));
    }
}