<?php

namespace Sakiot\LaravelSqlSpy\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Sakiot\LaravelSqlSpy\Vos\RouteVo;
use Sakiot\LaravelSqlSpy\Utils\Session\SessionUtil;

class InjectLaravelSqlSpyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) : mixed
    {
        $response = $next($request);

        if($response instanceof Response){
            SessionUtil::save($request);
            $this->viewInject($response);
        }
        
        return $response;
    }

    protected function viewInject(Response $response) : void
    {
        $content = $response->getContent();

        $inject_content = view('sql-spy::download_btn', [
            'download_route_name' => RouteVo::csvDownloadRouteNameFull(),
        ]);

        $pos = strripos($content, '</body>');

        if (false !== $pos) {
            $content = substr($content, 0, $pos) . $inject_content . substr($content, $pos);
        } else {
            $content = $content . $inject_content;
        }

        $original = null;
        if ($response instanceof \Illuminate\Http\Response && $response->getOriginalContent()) {
            $original = $response->getOriginalContent();
        }

        $response->setContent($content);
        $response->headers->remove('Content-Length');

        if ($original) {
            $response->original = $original;
        }
    }
}