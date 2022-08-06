<?php

use Illuminate\Support\Facades\Route;
use LaravelSqlSpy\Http\Controllers\DownloadController;
use LaravelSqlSpy\ValueObjects\RouteVo;

Route::group([
    'middleware' => ['web'],
    'as'         => RouteVo::prefix().'.',
    'prefix'     => RouteVo::prefix(),
], function () {
    Route::post(RouteVo::csvDownloadPath(), [DownloadController::class, 'csv'])->name(RouteVo::csvDownloadRouteName());
});
