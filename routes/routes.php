<?php

use Illuminate\Support\Facades\Route;
use Sakiot\LaravelSqlSpy\Vos\RouteVo;
use Sakiot\LaravelSqlSpy\Http\Controllers\DownloadController;

Route::group([
    'middleware' => ['web'],
    'as' => RouteVo::prefix() . '.',
    'prefix' => RouteVo::prefix(),
], function() {
    Route::post(RouteVo::csvDownloadPath(), [DownloadController::class, 'csv'])->name(RouteVo::csvDownloadRouteName());
});