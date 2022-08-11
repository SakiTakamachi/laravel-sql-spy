<?php

namespace LaravelSqlSpy\Stores;

use Carbon\Carbon;
use Illuminate\Http\Request;
use LaravelSqlSpy\DataTransferObjects\Session\SessionDto;
use LaravelSqlSpy\Handlers\GroupByQueryAndBacktrace;
use LaravelSqlSpy\ValueObjects\RouteVo;
use LaravelSqlSpy\ValueObjects\SessionVo;

class SessionStore
{
    public static function save(Request $request): void
    {
        $routeName = $request?->route()?->getName();

        if (is_null($routeName) || $routeName === RouteVo::csvDownloadRouteNameFull()) {
            return;
        }

        $page = $routeName ?: 'unknown';
        $page = str_replace('.', '_', $page);

        $reports = app()->make(GroupByQueryAndBacktrace::class)->get();

        session()->put(SessionVo::key(), serialize(new SessionDto($page, $reports->toArray(), Carbon::now())));
        session()->save();
    }

    public static function load(): SessionDto
    {
        return unserialize(session()->get(SessionVo::key(), serialize(new SessionDto('', [], null, false))));
    }
}
