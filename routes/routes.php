<?php

use Illuminate\Support\Facades\Route;
use LaravelSqlSpy\ValueObjects\RouteVo;
use LaravelSqlSpy\Http\Controllers\DownloadController;

Route::group([
    'middleware' => ['web'],
    'as' => RouteVo::prefix() . '.',
    'prefix' => RouteVo::prefix(),
], function() {
    Route::post(RouteVo::csvDownloadPath(), [DownloadController::class, 'csv'])->name(RouteVo::csvDownloadRouteName());
});