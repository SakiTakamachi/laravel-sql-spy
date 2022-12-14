<?php

namespace LaravelSqlSpy\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LaravelSqlSpy\Stores\SessionStore;
use LaravelSqlSpy\ValueObjects\RouteVo;

class InjectLaravelSqlSpyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next): mixed
    {
        $response = $next($request);

        if ($response instanceof Response) {
            SessionStore::save($request);
            $this->viewInject($response);
        }

        return $response;
    }

    protected function viewInject(Response $response): void
    {
        $content = $response->getContent();

        $injectContent = view('sql-spy::download-btn', [
            'downloadRouteName' => RouteVo::csvDownloadRouteNameFull(),
        ]);

        $pos = strripos($content, '</body>');

        if ($pos === false) {
            return;
        }

        $content = substr($content, 0, $pos).$injectContent.substr($content, $pos);

        $original = null;
        if ($response instanceof Response && $response->getOriginalContent()) {
            $original = $response->getOriginalContent();
        }

        $response->setContent($content);
        $response->headers->remove('Content-Length');

        if ($original) {
            $response->original = $original;
        }
    }
}
